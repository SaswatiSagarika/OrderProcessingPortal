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

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Account;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Vendor;
use QuickBooksOnline\API\Facades\CompanyInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Auth;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;

class DefaultService
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
     * Private function to create new records in database
     *
     * @param array $params  
     *
     * @return array
     */
    public function addNewUpdates($params)
    {
        try {
            $returnData['status'] = false;
            $em = $this->doctrine->getEntityManager();

            //creating records in Auth table
            $auth = new Auth;
            $auth->setAccessToken($params->getAccessToken())
            ->setRealm($params->getrealmID())
            ->setRefreshToken($params->getRefreshToken());

            $em->persist($auth);
            $em->flush();

            $returnData['status'] = true;
            $returnData['message'] = "new AccessToken is added. Enjoy working on Quickbooks";
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;
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
                $statement = "SELECT * FROM  Item WHERE Type='Inventory' STARTPOSITION 1 MAXRESULTS 10";
            } else {
                $statement = "SELECT * FROM ".$table ."STARTPOSITION".$startPoint."MAXRESULTS 10";
            }
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
                 'QBORealmID' => $auth[0]->getRrealm(),
                 'baseUrl' => "Development/Production"
            ));
            $error = $OAuth2LoginHelper->getLastError();
            
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
            if ($error) {
                $returnData['statusCode']      = $error->getHttpStatusCode();
                $returnData['helperMessage']   = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
                return $returnData;
            }
            $token = $dataService->updateOAuth2Token($refreshedAccessTokenObj);

            $authUpdates = $this->addNewUpdates($refreshedAccessTokenObj);

            if (false === $authUpdates['status']) {
                return $$authUpdates;
            }
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
            $auth = $this->doctrine->getRepository('AppBundle:Auth')->findById(1);

            // Prep Data Services            
            $dataService     = DataService::Configure(array(
                'auth_mode' => $this->parameter['authMode'],
                'ClientID' => $this->parameter['clientId'],
                'ClientSecret' => $this->parameter['clientSercret'],
                'accessTokenKey' => $auth[0]->getAccessToken(),
                'refreshTokenKey' => $auth[0]->getRefreshToken(),
                'QBORealmID' => $auth[0]->getRrealm(),
                'baseUrl' => "Development"
            ));

            $error = $dataService->getLastError();
            if ($error) {
                $returnData['statusCode']      = $error->getHttpStatusCode();
                $returnData['helperMessage']   = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
                //if accesstoken is expired
                $returnData['updateMessage']   = $this->refreshOauthtoken();
                //getting the dataservice again
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