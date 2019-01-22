<?php

/**
 * Description of DefaultService: used to call dataservice from Quickbooks 
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Account;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Vendor;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\CompanyInfo;
use QuickBooksOnline\API\Facades\PurchaseOrder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Auth;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;

class DefaultDataService
{
    /**
     *  @var array
     */
    private $parameter;
    
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     *  Constructor Function for iniatialize dependencies.
     *  
     *  @param Registry $doctrine
     *  @param Array $parameters
     *   
     *  @return void
     */
    public function __construct(Registry $doctrine, Array $parameter) {
        $this->doctrine = $doctrine;
        $this->parameter = $parameter;
    }
    
    /**
     * Function to get datacount from quickbooks based on table name
     *
     * @param string $table  
     *
     * @return array
     **/
    public function createInvoice($param)
    {
        try {
            $returnData['status'] = false;
            $dataService = $this->getDataService();
            $invoiceToCreate = Invoice::Create($param);
            $resultObj = $dataService->Add($invoiceToCreate);

            $error = $dataService->getLastError();
            if ($error) {
                $returnData['statusCode'] = $error->getHttpStatusCode();
                $returnData['helperMessage'] = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
            }
            $returnData['status'] = true; 
            $returnData['message'] = $resultObj;
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;
        
    }

    /**
     * Function to set new po in quickbooks
     *
     * @param string $table  
     *
     * @return array
     **/
    public function createPurchaseOrder($param)
    {
        try {
            $returnData['status'] = false;
            $dataService = $this->getDataService();
            $invoiceToCreate = PurchaseOrder::Create($param);
            $resultObj = $dataService->Add($invoiceToCreate);

            $error = $dataService->getLastError();
            if ($error) {
                $returnData['statusCode'] = $error->getHttpStatusCode();
                $returnData['helperMessage'] = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
            }
            $returnData['status'] = true; 
            $returnData['message'] = $resultObj;
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;
        
    }

    /**
     * Function to get datacount from quickbooks based on table name
     *
     * @param string $table  
     *
     * @return array
     **/
    public function getDataCount($table)
    {
        try { 
            $returnData['status'] = false;
            $dataService = $this->getDataService();

            $returnData['count'] = $dataService->Query("SELECT COUNT" . "(" . "*" . ")" . " FROM ".$table);
            
            $returnData['dataService'] = $dataService;
            $returnData['status'] = true;          
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
       
        return $returnData;
        
    }
    
    /**
     * Function to parse auth url
     *
     * @param string $url  
     *
     * @return array
     **/
    public function parseAuthRedirectUrl($url)
    {
        parse_str ($url, $qsArray);
        return array(
            'code' => $qsArray['code'],
            'realmId' => $qsArray['realmId']
        );
    }

     /**
     * Private function to get records from database
     *
     * @param array $table  
     * @param string $startPoint 
     *
     * @return array
     */
     public function getData($table, $startPoint)
     {
        try {
            
            $returnData['status'] = false;
            $dataService = $this->getDataService();
            if ( 'Item' === $table) {
                $statement = "SELECT * FROM  Item WHERE Type='Inventory' STARTPOSITION ".$startPoint." MAXRESULTS 10";
            } else {
                $statement = "SELECT * FROM ".$table ." STARTPOSITION ".$startPoint." MAXRESULTS 10";
            }
            //getting the records from the QB database
            $returnData['data'] = $dataService->Query($statement);
             $returnData['status'] = true;
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;
    }

    /**
     * Private function to refresh the accessToken  
     *
     * @return array
     */
    public function refreshOauthtoken()
    {
        try {

            $returnData['status'] = false;
            $auth = $this->doctrine->getRepository('AppBundle:Auth')->findById(1);
            $dataService = DataService::Configure(array(
                 'auth_mode' => $this->parameter['authMode'],
                 'ClientID' => $this->parameter['clientId'],
                 'ClientSecret' => $this->parameter['clientSercret'],
                 'refreshTokenKey' => $auth[0]->getRefreshToken(),
                 'QBORealmID' => $auth[0]->getRealm(),
                 'baseUrl' => "Development/Production"
            ));
            
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();

            $error = $OAuth2LoginHelper->getLastError();
            if ($error) {
                $returnData['statusCode']      = $error->getHttpStatusCode();
                $returnData['helperMessage']   = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
                return $returnData;
            }

            $token = $dataService->updateOAuth2Token($refreshedAccessTokenObj);
            $returnData['token'] = $token;
            $returnData['status'] = true;
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;       
    }

    /**
     * Private function to get the dataService  
     *
     * @return array
     */
    public function getDataService() {
        try {
            $auth = $this->doctrine->getRepository('AppBundle:Auth')->find(1);
            // Prep Data Services            
            $dataService     = DataService::Configure(array(
                'auth_mode' => $this->parameter['authMode'],
                'ClientID' => $this->parameter['clientId'],
                'ClientSecret' => $this->parameter['clientSercret'],
                'accessTokenKey' => $auth->getAccessToken(),
                'refreshTokenKey' => $auth->getRefreshToken(),
                'QBORealmID' => $auth->getRealm(),
                'baseUrl' => "Development"
            ));

            $count = $dataService->Query("SELECT COUNT" . "(" . "*" . ")" . " FROM Account");
            
            if(!isset($count)){
                
                $refreshAccessToken   = $this->refreshOauthtoken();
                //getting the dataservice again
                if (false === $refreshAccessToken['status']) {
                    
                    return $refreshAccessToken;
                }

                $dataService = $this->getDataService();
            }
        }
        catch (\Exception $e) {
            
            $returnData['errorMessage'] = $e->getMessage();
            
            //if accesstoken is expired
            $refreshAccessToken   = $this->refreshOauthtoken();
            //getting the dataservice again
            if (false === $refreshAccessToken['status']) {
                return $refreshAccessToken;
            }

            $dataService = $this->getDataService();
        }
        
        return $dataService;
    }
}