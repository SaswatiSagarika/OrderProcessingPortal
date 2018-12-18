<?php
/**
 * Controller for order Section.
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

class OrderController extends FOSRestController
{
    /**
     ** REST action which returns get the data to Product.
     *
     * @Post("/api/order")
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
     * @return array
     */
    public function getProductDetailAction(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            // if content is not provided.
            if (!$requestContent) {
                $message = $this->get('translator')->trans('api.missing_parameters');
                throw new NotFoundHttpException($message);
            }
            //sanitizing and checking the params
            $validateData = $this->container->get('app.service.order')->validateOrderDetails($requestContent);
            
            if (false === $validateData['status']) {
                $message = $this->get('translator')->trans($validateData['message']);
                throw new NotFoundHttpException($message);
            }
            
            //getting the result array
            $OrderArr = $this->container->get('app.service.product')->placeOrders($validateData);
            
            if (false === $OrderArr['status']) {
                $message = $this->get('translator')->trans($OrderArr['message']);
                throw new NotFoundHttpException($message);
            }
            
            $resultArray['success'] = $productArrf;
            
        }
        catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }
        return $resultArray;
    }
    
}