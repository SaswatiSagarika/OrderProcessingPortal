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
            $returnData['status'] = false;
            
            if (!json_decode($content = $request->getContent(), true)) {
                $returnData['errorMessage'] = ErrorConstants::$apiErrors['INVALIDJSON'];
                return $returnData;
                
            }
            
            // get the request headers
            $headers = $request->headers;
            $auth    = $headers->get('Authorization');
            $hash    = hash_hmac('sha1', $content, $this->hash_signature_key);
            // Comparing Request Hash with Server auth Hash.
            if ($hash !== $auth) {
                
                $returnData['errorMessage'] = ErrorConstants::$apiErrors['INVALIDAUTHORIZATION'];
                return $returnData;
            }
            
            $returnData['status'] = true;
            
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $returnData;
    }
}