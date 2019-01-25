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
use Symfony\Component\HttpFoundation\Session\Session;

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

            // if (!json_decode($content = $request->getContent(), true)) {
            //      print_r(1);exit();
            //     $message = ErrorConstants::$apiErrors['INVALIDJSON'];
            //     throw new Exception("$message");
                
            // }
           
            $status = true;
            
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        $returnData['status']= $status;

        return $returnData;
    }

    /**
     * Function to check route
     *
     * @param array $request
     *
     * @return true
     **/
    public function isOpenRoute($request)
    {
        return (!empty($request->getPathInfo())) ? 1 : 0;
    }

    /**
     * Function to check Auth
     *
     * @return true
     **/
     public function isAuth()
    {
        $session = new Session();
        if ($session->has("authenticated")) {
            return $session->get("authenticated");
        }
         return false;
    }
}