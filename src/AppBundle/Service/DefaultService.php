<?php

/**
 * Description of DefaultService: used to call dataservice from Quickbooks 
 * @author Saswati
 * 
 * @category Service
 *
 */
namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Account;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Vendor;
use QuickBooksOnline\API\Facades\CompanyInfo;

class DefaultService
{   
    /**
     * @var serviceContainer
     */
    protected $serviceContainer;

    /**
     * 
     * @param $service_container
     *
     * @return void
     */

    public function __construct($service_container) {
        $this->serviceContainer = $service_container;
    }

    /**
     * Function to get dataservice 
     * @return array
     *
     **/
    public function getDataServiceParams()
    {   
        try {

            // getting the parameter from database
            $clientId = $this->serviceContainer->getParameter('clientId');
            $clientSercret = $this->serviceContainer->getParameter('clientSercret');
            $redirecturl = $this->serviceContainer->getParameter('redirecturl');
            $auth_mode = $this->serviceContainer->getParameter('auth_mode');
            $scope = $this->serviceContainer->getParameter('scope');
            // Prep Data Services
            $dataService = DataService::Configure(array(
                'auth_mode' => $auth_modescope,
                'ClientID' => $clientId,
                'ClientSecret' =>  $clientSercret,
                'RedirectURI' => $redirecturl,
                'scope' => $scope,
                'baseUrl' => "development",        
            ));

            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
            // set header properties
            $headers = array(
                'Content-Type: application/json; charset=UTF-8',
                'Content-Length: '.strlen(json_encode($dataService))
                );

            $url = 'https://appcenter.intuit.com/connect/oauth2?'.http_build_query($dataService);

            $ch = curl_init();
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, true);
            //grab URL and pass it to the browser
            $jsonData = curl_exec($ch);
            $info    = curl_getinfo($ch);
            curl_close($ch);

            //get authenticate code
            $parseUrl = parseAuthRedirectUrl($info);
            $authorizationCode = $parseUrl['code'];
            $returnData['RealmID'] = $parseUrl['realmId'];

            //get access token
            $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($authorizationCode, $returnData['RealmID']);
            $returnData['accessTokenValue'] = $accessTokenObj->getAccessToken();
            $returnData['refreshTokenValue'] = $accessTokenObj->getRefreshToken();
            // $returnData['service'] =  $dataService;
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }

        return $returnData;
    }

     /**
     * Function to get data from quickbooks based on table name
     *
     * @param $table  
     *
     * @return array
     *
     **/
    public function getData($table)
    {   
        try {

            $clientId = $this->serviceContainer->getParameter('clientId');
            $clientSercret = $this->serviceContainer->getParameter('clientSercret');
            $auth_mode = $this->serviceContainer->getParameter('auth_mode');
            // Prep Data Services
            $data = $this->getDataServiceParams();
            $dataService = DataService::Configure(array(
                'auth_mode' =>  $auth_mode,
                'ClientID' => $clientId,
                'ClientSecret' => $clientSercret,
                'accessTokenKey' => $data['accessTokenValue'],
                'refreshTokenKey' => $data['refreshTokenValue'],
                'QBORealmID' => $data['RealmID'],
                'baseUrl' => "Development"
            ));

            //getting data from the table defined
            switch ($table) {
                case 'Account':
                    $data = $dataService->Query("SELECT * FROM Account");
                    break;
                case 'Item':
                    $data = $dataService->Query("SELECT * FROM Item WHERE Type='Inventory'");
                    break;
                case 'Vendor':
                    $data = $dataService->Query("SELECT * FROM Vendor");
                    break;
                default:
                    $data = "not valid table";
                    break;
            }

            //checking if any error occured
            $error = $dataService->getLastError();
            if ($error) {
                $returnData['statusCode'] = $error->getHttpStatusCode();
                $returnData['helperMessage'] = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
            }
            
            $returnData['data'] = $data;

        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $returnData;
        
    }

     /**
     * Function to parse auth url
     *
     * @param $url  
     *
     * @return array
     *
     **/
    public function parseAuthRedirectUrl($url)
    {
        parse_str($url,$qsArray);
        return array(
            'code' => $qsArray['code'],
            'realmId' => $qsArray['realmId']
        );
    }
}

