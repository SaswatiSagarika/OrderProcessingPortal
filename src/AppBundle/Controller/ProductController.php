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
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

class ProductController extends FOSRestController
{
    /**
    ** REST action which returns get the data to Product.
    *
    * @Get("/api/products")
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
    * @return array
    */
	public function getProductDetailAction(Request $request) 
    {
        try {
            $demo = json_decode($request->getContent(), true);
            // if content is not provided.
            if (!$demo) {
                $message = $this->get('translator')->trans('api.missing_parameters');
                throw new NotFoundHttpException("error1");
            }
            //sanitizing and checking the params
            $productData =  $this->container
                ->get('app.service.product')
                ->checkDetails($demo);

            if (false === $productData['status']) {
               $message = $this->get('translator')->trans($returnData['message']);
                throw new NotFoundHttpException("error2");
            }


            //getting the result array
            $resultArr =  $this->container
                ->get('app.service.product')
                ->getProductResponse($productData);

            if (false === $resultArr['status']) {
                   $message = $this->get('translator')->trans($resultArr['message']); 
                    throw new NotFoundHttpException("error3");
            }

            $resultArray['success'] = $resultArr;

        } catch (NotFoundHttpException $e) {
            $resultArray['error'] = $e->getMessage();
        } catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }
        return $resultArray;
	}

}