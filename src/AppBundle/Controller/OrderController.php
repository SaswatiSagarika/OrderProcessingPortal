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
use FOS\RestBundle\Controller\Annotations\Get;
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
     *       "format"="{""TotalAmt"":""25.0"",""Line"":""[""{""DetailType"":""ItemBasedExpenseLineDetail"",""Amount"":""25.0"",""Id"":""1"",""ItemBasedExpenseLineDetail"":""{""ItemRef"":""{""name"":""GardenSupplies"",""value"":""38""}"",""CustomerRef"":""{""name":""CoolCars"",""value"":""3""}"",""Qty"":""1"",""TaxCodeRef"":""{""value"":""NON""}"",""BillableStatus"":""NotBillable"",""UnitPrice"":""25""}""}""]",""APAccountRef"":""{""name"":""AccountsPayable(A/P)"",""value"":""33""}"",""VendorRef"":""{""name"":""HicksHardware"",""value"":""41""}""}"
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
    public function placeOrderAction(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            // if content is not provided.
            $translator =  $this->get('translator');

            $orderService = $this->get('app.service.order');
            $validateService = $this->get('app.service.validate_data');
            
            if (!$requestContent['Line']|| !$requestContent['TotalAmt']) {
                throw new NotFoundHttpException($translator->trans('api.invalid_data'));
            }

            // checking the params the account details provided
            $orderDetails = $validateService->validateOrderDetails($requestContent);
            if (false === $orderDetails['status']) {
                throw new NotFoundHttpException($translator->trans($orderDetails['message']));
            }
            $orderResultArray = $orderService->placeCustomerOrderDetails($requestContent);
            if (false === $orderResultArray['status']) {
                throw new NotFoundHttpException($translator->trans($orderResultArray['message']));
            }
            
        } catch (Exception $e) {
            $orderResultArray['error'] = $e->getMessage();
        }
        
        return new JsonResponse($orderResultArray);
    }

    /**
     ** REST action which returns get the data to Order.
     *
     * @Get("/api/orderHistory")
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
     *       "format"="{""orderID"":""5678987990798"",""customer"":""Amy's""}"}"
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
    public function getOrderHistoryAction(Request $request)
    {
        try {

            $requestContent = json_decode($request->getContent(), true);
            // if content is not provided.
            $translator =  $this->get('translator');

            $orderService = $this->get('app.service.order');
            $validateService = $this->get('app.service.validate_data');
            
            // checking the params the account details provided
            $orderDetails = $validateService->checkDetails($requestContent);
            if (false === $orderDetails['status']) {
                throw new NotFoundHttpException($translator->trans($orderDetails['message']));
            }

            $orderResultArray = $orderService->getOrderHistoryDetails($requestContent);
            if (false === $orderResultArray['status']) {
                throw new NotFoundHttpException($translator->trans($orderResultArray['message']));
            }
            
        } catch (Exception $e) {
            $orderResultArray['error'] = $e->getMessage();
        }
        
        return new JsonResponse($orderResultArray);
    }

}