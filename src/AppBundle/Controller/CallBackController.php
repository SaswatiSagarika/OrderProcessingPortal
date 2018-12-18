<?php
/**
 * Controller for home product ui functions.
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
use Symfony\Component\HttpFoundation\Response;
use QuickBooksOnline\API\DataService\DataService;
use Symfony\Component\HttpFoundation\Session\Session;

class CallBackController extends Controller
{
    /**
     * @Route("/callback", name="callback")
     *
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $session = new Session();
        
        // Prep Data Services
        $dataService = DataService::Configure(array(
            'auth_mode' => $this->container->getParameter('quickbooks')['authMode'],
            'ClientID' => $this->container->getParameter('quickbooks')['clientId'],
            'ClientSecret' =>  $this->container->getParameter('quickbooks')['clientSercret'],
            'RedirectURI' => $this->container->getParameter('quickbooks')['redirectUrl'],
            'scope' => $this->container->getParameter('quickbooks')['scope'],
            'baseUrl' => "development",        
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

        $data = $request->server->get('QUERY_STRING');
        //parsing query string
        $parseUrl = $this->container
                        ->get('app.service.default_data')
                        ->parseAuthRedirectUrl($data);
        //getting the accessToken
        $accessTokenObj = $OAuth2LoginHelper
                            ->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
        $session->set('code', $accessTokenObj);

        $saveData = $this->container
            ->get('app.service.default_data')
            ->addNewUpdates($accessTokenObj);
        

    }


}

