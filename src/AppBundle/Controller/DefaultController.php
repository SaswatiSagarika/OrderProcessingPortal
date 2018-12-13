<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
   /**
     * @Route("/account", name="account")
     */
    public function indexAction()
    {
        $response = $this->container
                ->get('app.service.default')
                ->getDataServiceParams()
            ;
           
        // replace this example code with whatever you need
        return new JsonResponse($response);
    }
}