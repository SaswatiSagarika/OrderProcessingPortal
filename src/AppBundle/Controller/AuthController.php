<?php
/**
 * Controller for product Section.
 *
 * @author Saswati
 *
 * @category Controller
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class AuthController extends FOSRestController
{
    /**
     ** REST action which returns get the data to Product.
     *
     * @Post("/api/register")
     * @View(statusCode=200)
     *
     * @(
     *   resource =false,
     *   description = "API to get the data to Product",
     * requirements={
     *      {
     *          "name"="_format",
     *          "dataType"="string",
     *          "description"="Response format"
     *      },
     *      {
     *          "name"="_locale",
     *          "requirement"="en|my"
     *      }
     *  },
     *  parameters={{
     *       "name"="csndk",
     *       "dataType"="Json",
     *       "required"="true",
     *       "description"="Json with name or category",
     *       "format"="{""name"":""sprinkler"",""category"":""building""}"
     *
     *   }},
     *  statusCodes={
     *         200="Returned when successful",
     *         401="Returned when not authorized",
     *  }
     *)
     * @param Request $request
     *
     * @return array
     */
    public function registrationAction(Request $request)
    {
        try {

            $requestContent = json_decode($request->getContent(), true);
            $translator = $this->get('translator');
            // if content is not provided.
            if (!$requestContent) {
                throw new NotFoundHttpException($translator->trans('api.missing_parameters'));
            }
            $registerService = $this->get('app.service.registration');
            $validateService = $this->get('app.service.validate_data');
            //sanitizing and checking the params
            $registerData = $validateService->checkDetails($requestContent);
            
            if (false === $registerData['status']) {
                throw new NotFoundHttpException($translator->trans($registerData['message']));
            }
            
            //getting the result array
            $registerResult = $registerService->registerUserResponse($registerData);
            if (false === $registerResult['status']) {
                throw new NotFoundHttpException($translator->trans($registerResult['message']));
            }
            
            $resultArray['success'] = $registerResult;
            
        }
        catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }
        
        return new JsonResponse($resultArray);
    }

    /**
    ** REST action which returns sends the data to phone number.
    * @Post("/api/sendotp")
    * @View(statusCode=200)
    *
    * @(
    *   resource =false,
    *   description = "API to send otp to phone number",
    * requirements={
    *      {
    *          "name"="send",
    *          "dataType"="string",
    *          "description"="Response format"
    *      },
    *      {
    *          "name"="send",
    *          "requirement"="en|my"
    *      }
    *  },
    *  parameters={{
    *       "name"="send",
    *       "dataType"="Json",
    *       "required"="true",
    *       "description"="Json with username and phone number",
    *       "format"="{""name"":""John"",""email"":""demo@gmail.com""}"
    *       
    *   }},
    *  statusCodes={
    *         200="Returned when successful",
    *         401="Returned when not authorized",
    *  }
    * )
    * @return array
    */
    public function sendOtpAction(Request $request)
    {   
        try {
            $data = json_decode($request->getContent(), true);
            if (!$data) {
                throw new NotFoundHttpException($this->get('translator')->trans('api.missing_parameters'));
            }

            $mailerService = $this->get('app.service.mailer');
            $validateService = $this->get('app.service.validate_data');
            //validating the data in the form contain
            $userData = $validateService->checkDetails($data);
            if (false === $userData['status'] ) {
                throw new NotFoundHttpException($this->get('translator')->trans($userData['message']));
            }
            //sending the otp message
            $optMessage = $mailerService->sendOtpToEmail($data);

            if (!$optMessage['status']) {
                $message = $this->get('translator')->trans('api.error');
                throw new BadRequestHttpException($message);
            }
            $resultArray['success'] = $this->get('translator')->trans('api.otp_success');

        }  catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }

        return new JsonResponse($resultArray);
    }

    /**
    **REST action which returns success if the otp is verified.
    * @Post("/api/verifyotp")
    *
    * @View(statusCode=200)
    *
    * @(
    *   resource =false,
    *   description = "API to send otp to phone number",
    * requirements={
    *      {
    *          "name"="_format",
    *          "dataType"="string",
    *          "description"="Response format"
    *      },
    *      {
    *          "name"="_locale",
    *          "requirement"="en|my"
    *      }
    *  },
    *  parameters={{
    *       "name"="verify",
    *       "dataType"="Json",
    *       "required"="true",
    *       "description"="Json with username and phone number",
    *       "format"="{""name"":""John"",""email"":""demo@gmail.com"",""otp"":""123456""}"
    *       
    *   }},
    *  statusCodes={
    *         200="Returned when successful",
    *         401="Returned when not authorized",
    *  }
    *)
    * @return array
    */
    public function verifyOtpAction(Request $request)
    {
        try { print_r($request->getContent(), true);
            $data = json_decode($request->getContent(), true);

            if (!$data) {
                throw new BadRequestHttpException($this->get('translator')->trans('api.missing_parameters'));
            }
            $validateService = $this->get('app.service.validate_data');
            //validating the data in the form contain
            $userData = $validateService->checkDetails($data);

            if (false === $userData['status'] ) {
                $message = $this->get('translator')->trans($userData['message']);
                throw new NotFoundHttpException($message);
            }
            $em = $this->getDoctrine()->getManager();
            
            //verify the otp send.
            $otpVerification = $em->getRepository('MainBundle:User')->verifyOtp($userData);

            if (!$otpVerification) {
                throw new BadRequestHttpException($otpVerification);
            }

            $resultArray['success'] = $this->get('translator')->trans('api.otp_verified');

        } catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }
        return new JsonResponse($resultArray);
    }

    /**
    **REST action which returns success if the otp is verified.
    * @Post("/api/login")
    *
    * @View(statusCode=200)
    *
    * @(
    *   resource =false,
    *   description = "API to send otp to phone number",
    * requirements={
    *      {
    *          "name"="_format",
    *          "dataType"="string",
    *          "description"="Response format"
    *      },
    *      {
    *          "name"="_locale",
    *          "requirement"="en|my"
    *      }
    *  },
    *  parameters={{
    *       "name"="verify",
    *       "dataType"="Json",
    *       "required"="true",
    *       "description"="Json with username and phone number",
    *       "format"="{""name"":""John"",""password"":""97974237340""}"
    *       
    *   }},
    *  statusCodes={
    *         200="Returned when successful",
    *         401="Returned when not authorized",
    *  }
    *)
    * @return array
    */
    public function loginAction(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!$data) {
                throw new BadRequestHttpException($this->get('translator')->trans('api.missing_parameters'));
            }
            $validateService = $this->get('app.service.validate_data');
            $registerService = $this->get('app.service.registration');

            //validating the data in the form contain
            $loginData = $validateService->checkDetails($data);

            if (false === $loginData['status'] ) {
                throw new NotFoundHttpException($this->get('translator')->trans($loginData['message']));
            }
            $em = $this->getDoctrine()->getManager();
            
            //verify the login details.
            $loginResult = $registerService->loginResponse($loginData);

            if (false === $loginResult['status']) {
                throw new BadRequestHttpException($this->get('translator')->trans($userData['message']));
            }
            
            $resultArray['success'] = $this->get('translator')->trans('api.otp_verified');

        } catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }
        return new JsonResponse($resultArray);
    }
    
}