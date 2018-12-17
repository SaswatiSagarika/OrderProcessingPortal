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
    private $parameters;
    
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
    public function __construct(Registry $doctrine, Array $parameters) {
        $this->doctrine = $doctrine;
        $this->parameters = $parameters;
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

            $em = $this->doctrine->getEntityManager();
            $auth = $this->doctrine->getRepository('MainBundle:Auth')->findBy(array(),array('id'=>'DESC'),0,1);

            
            $clientId        = $this->parameter('clientId');
            $clientSecret   = $this->parameter('clientSercret');
            $authMode        = $this->parameter('authMode');
            // Prep Data Services            
            $dataService     = DataService::Configure(array(
                'auth_mode' => $authMode,
                'ClientID' => $clientId,
                'ClientSecret' => $clientSecret,
                'accessTokenKey' => $auth['accessToken'],
                'refreshTokenKey' => $auth['refreshToken'],
                'QBORealmID' => $auth['Realm'],
                'baseUrl' => "Development"
            ));
            
            //checking if any error occured
            $error = $dataService->getLastError();
            if ($error) {
                $returnData['statusCode']      = $error->getHttpStatusCode();
                $returnData['helperMessage']   = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
                $returnData['updateMessage'] = $this->refreshOauthtoken();
                
                // $returnData['updateMessage'] = "AccessToken is getting refreshed. Please run the query again";
                return $returnData;
            }
            
            //getting data from the table defined
            $statement = "SELECT COUNT" . "(" . "*" . ")" . "FROM ".$table;
            $returnData['count'] = $dataService->Query($statement);
            $returnData['dataService'] = $dataService;

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
        parse_str($url, $qsArray);
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
     * @param string $dataCount   
     *
     * @return array
     */
     public function getData($table, $startPoint, $dataCount)
     {
        try {
             $returnData['status'] = false;
            $dataService = $dataCount['dataService'];
            if ( 'Item' === $table) {
                $statement = "SELECT COUNT" . "(" . "*" . ")" . "FROM ".$table."WHERE Type='Inventory'STARTPOSITION".$startPoint."MAXRESULTS 10";
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

            $auth = $this->doctrine->getRepository('MainBundle:Auth')->findBy(array(),array('id'=>'DESC'),0,1);

            $clientId        = $this->parameter('clientId');
            $clientSecret   = $this->parameter('clientSercret');

            $oauth2LoginHelper = new OAuth2LoginHelper( $clientId ,$clientSecret);
            
            $error = $OAuth2LoginHelper->getLastError();
            $accessTokenObj = $oauth2LoginHelper->
            refreshAccessTokenWithRefreshToken($auth['Realm']);

            if($error){
                $returnData['statusCode']      = $error->getHttpStatusCode();
                $returnData['helperMessage']   = $error->getOAuthHelperError();
                $returnData['responseMessage'] = $error->getResponseBody();
            }else{
                $token = $dataService->updateOAuth2Token($refreshedAccessTokenObj);

                $returnData = $this->addNewUpdates($token);
            }
            
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;
    }
}