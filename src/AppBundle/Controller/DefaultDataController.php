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

class DefaultDataController extends Controller
{
   /**
     * this file to show the gettoken
     *
     * @Route("/gettoken", name="gettoken")
     *
     * @return $response
     */
   public function indexAction ()
   {
    $param = $this->container->getParameter('quickbooks');
    $session = new Session();
    $dataService = DataService::Configure(array(
        'auth_mode' => $param['authMode'],
        'ClientID' => $param['clientId'],
        'ClientSecret' => $param['clientSercret'],
        'response_type'=> 'code',
        'scope' => $param['scope'],
        'RedirectURI' => $param['redirectUrl'],
        'baseUrl' => "Development"
    ));

    $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
    $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();

    if ($session->has("code")) {
     $data = $session->get("code");
     
     $this->container
     ->get('app.service.default_data')
     ->addNewUpdates($accessTokenObj);
 }

        // open the home twig
 return $this->render('default/home.html.twig', [
    'url' => $authUrl,
]);
}    
}