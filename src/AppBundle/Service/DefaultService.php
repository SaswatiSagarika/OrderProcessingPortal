<?php

/**
 * Description of DefaultService: used to call dataservice from Quickbooks 
 *
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
            $authMode = $this->serviceContainer->getParameter('auth_mode');
            $accessTokenKey = $this->serviceContainer->getParameter('accessTokenKey');
            $refreshTokenKey = $this->serviceContainer->getParameter('refreshTokenKey');
            $QBORealmID = $this->serviceContainer->getParameter('QBORealmID');
            // Prep Data Services            
            $dataService = DataService::Configure(array(
                'auth_mode' =>  $auth_mode,
                'ClientID' => $clientId,
                'ClientSecret' => $clientSercret,
                'accessTokenKey' => $accessTokenKey,
                'refreshTokenKey' => $refreshTokenKey,
                'QBORealmID' => $QBORealmID,
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

