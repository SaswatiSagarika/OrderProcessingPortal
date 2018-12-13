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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use QuickBooksOnline\API\DataService\DataService;

class CallBackController extends Controller
{
    /**
     * @Route("/callback", name="")
     */
    public function indexAction(Request $request)
    {
		$clientId = $this->container->getParameter('clientId');
        $clientSercret = $this->container->getParameter('clientSercret');
        $redirecturl = $this->container->getParameter('redirecturl');
        $auth_mode = $this->container->getParameter('auth_mode');
        $scope = $this->container->getParameter('scope');
        // Prep Data Services
        $dataService = DataService::Configure(array(
            'auth_mode' => $auth_mode,
            'ClientID' => $clientId,
            'ClientSecret' =>  $clientSercret,
            'RedirectURI' => $redirecturl,
            'scope' => $scope,
            'baseUrl' => "development",        
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $data = $request->server->get('QUERY_STRING');
        $parseUrl = $this->container
                ->get('app.service.default')
                ->parseAuthRedirectUrl($data);

        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
        $dataService->updateOAuth2Token($accessToken);
        
        
        
    }
}
