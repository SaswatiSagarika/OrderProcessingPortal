<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use QuickBooksOnline\API\DataService\DataService;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
   /**
     * this file to show the gettoken
     *
     * @Route("/gettoken", name="gettoken")
     * 
     *
     * @return $response
     */
    public function indexAction()
    {
        $session= new Session();

        $dataService = DataService::Configure(array(
            'auth_mode' => $this->container->getParameter('quickbooks')['authMode'],
            'ClientID' => $this->container->getParameter('quickbooks')['clientId'],
            'ClientSecret' => $this->container->getParameter('quickbooks')['clientSercret'],
            'response_type'=> 'code',
            'scope' => $this->container->getParameter('quickbooks')['scope'],
            'RedirectURI' => $this->container->getParameter('quickbooks')['redirectUrl'],
            'baseUrl' => "Development"
        ));

        if ($session->get('code')) { 
            $accessTokenObj = $session->get('code');
        }

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

            // replace this example code with whatever you need
        return $this->render('default/home.html.twig', [
            'url' => $authUrl,
        ]);
    }    
}