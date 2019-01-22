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
     * @param Request $request
     *
     * @return array
     */
    public function getProductDetailAction(Request $request)
    {
        try {

            $requestContent = json_decode($request->getContent(), true);

            $translator = $this->get('translator');
            // if content is not provided.
            if (!$requestContent) {
                throw new NotFoundHttpException($translator->trans('api.missing_parameters'));
            }
            $productService = $this->get('app.service.product');
            $validateService = $this->get('app.service.validate_data');
            //sanitizing and checking the params
            $productData = $validateService->checkDetails($requestContent);
            
            if (false === $productData['status']) {
                throw new NotFoundHttpException($translator->trans($productData['message']));
            }
            
            //getting the result array
            $productArr = $productService->getProductResponse($productData);
            if (false === $productArr['status']) {
                throw new NotFoundHttpException($translator->trans($productArr['message']));
            }
            
            $resultArray['success'] = $productArr;
            
        }
        catch (Exception $e) {
            $resultArray['error'] = $e->getMessage();
        }
        
        return new JsonResponse($resultArray);
    }
    
}