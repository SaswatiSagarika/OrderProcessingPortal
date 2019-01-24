<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$products = $this->container->get('app.service.product')->getProductResponse();
        $customer = $this->getDoctrine()->getRepository('AppBundle:Customer')->getCustomerDetail();
        

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

}
