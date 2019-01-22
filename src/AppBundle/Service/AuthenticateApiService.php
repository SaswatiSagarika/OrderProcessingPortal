<?php

/**
 * Description of AuthenticateApiService. This service is used for authenticating the api request
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace AppBundle\Service;

use AppBundle\Constants\ErrorConstants;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AuthenticateApiService
{
    /**
     *  @var string
     */
    private $hash_signature_key;
    
    /**
     *  Constructor Function for iniatialize dependencies.
     *  
     *  @param string $hash_signature_key
     *   
     *  @return void
     */
    public function __construct(string $hash_signature_key)
    {
        $this->hash_signature_key = $hash_signature_key;
    }
    
    /**
     * Function to check content and Api header
     *
     * @param array $request
     *
     * @return true
     **/
    public function authenticateRequest($request)
    {
        try {
            $status = false;

            if (!strpos($request->getPathInfo(), 'api/') && $this->isOpenRoute($request)) {
                $returnData['status']= true;
                return $returnData;
            }
            if (!json_decode($content = $request->getContent(), true)) {
                $message = ErrorConstants::$apiErrors['INVALIDJSON'];
                throw new Exception("$message");
                
            }
           
            $status = true;
            
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        $returnData['status']= $status;

        return $returnData;
    }

    /**
    */
    public function isOpenRoute($request)
    {
        return (!empty($request->getPathInfo())) ? 1 : 0;
    }
}