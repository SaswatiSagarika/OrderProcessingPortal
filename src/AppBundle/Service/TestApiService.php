<?php

/**
 * Description of TestApiService. This service helps for making an API call
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace AppBundle\Service;

// use AppBundle\Constants\ErrorConstants;

class TestApiService
{
   
    /**
     * Function to call Api
     *
     * @param $url
     * @param $headers
     * @param $verb
     * @param $content
     * @return array
     *
     **/
    public function callingApi($url, $headers, $verb, $content)
    {   
        try {
            //create a new cURL resource
            $ch = curl_init();

            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           
            
            // grab URL and pass it to the browser
            $returnData = curl_exec($ch);
            // close cURL resource, and free up system resources
            curl_close($ch);
        } catch (\Exception $e) {
            
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $returnData;
    }

}