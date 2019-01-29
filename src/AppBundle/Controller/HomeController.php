<?php
/**
 * Controller for Home Section.
 *
 * @author Saswati
 *
 * @category Controller
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller
{
     /**
     * function to show product UI
     *
     * @Route("/homepage", name="homepage")
     *
     * @param Request $request
     *
     */
     public function indexAction(Request $request)
     {
        //check if authenticated or not
        $auth = $this->container->get('app.service.auth')->isAuth();
        if (false === $auth) {
            return $this->redirect($this->generateUrl('user_login'));
        }
        //getting product and customer data
        $products = $this->container->get('app.service.product')->getProductResponse($request->query->all());
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->getCustomerDetail();
        //paginating the product data
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products['response']['product'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            4/*limit per page*/
        );

        return $this->render('page/index.html.twig', [
            'products' => $pagination,
            'categories' => $products['response']['filter']['category'],
            'customer' => $customer
        ]);
    }

    /**
     * function to show order UI
     *
     * @Route("/orderDetail", name="orderlist")
     *
     * @param Request $request
     * 
     */
    public function orderAction(Request $request)
    {
         //check if authenticated or not
        $auth = $this->container->get('app.service.auth')->isAuth();
        if (false === $auth) {
            return $this->redirect($this->generateUrl('user_login'));
        }
        //get the order details
        $orders = $this->container->get('app.service.order')->getOrderHistoryDetails($request->query->all());
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->getCustomerDetail();
        if (false === $orders['status'] ) {
            $orders['response']['order'] = $orders['status'];
        }
        //paginating the product data
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $orders['response']['order'], /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('order/orderhistoy.html.twig', [
            'orders' => $pagination,
            'customer' => $customer
        ]);
    }

}
