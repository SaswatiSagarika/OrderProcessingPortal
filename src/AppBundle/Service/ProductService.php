<?php

/**
 * Service for products Section. This service used for verifying the product details and process and provide product response for the searched data provided.
 *
 * @author Saswati
 * 
 * @category Service
 */
namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use DOMDocument;

/**
 * Class for product services
 */
class ProductService
{   
    /**
     * @var $serviceContainer
     */
    protected $serviceContainer;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @param $doctrine
     *
     * @return void
     */

    public function __construct($doctrine, $service_container) {
        $this->doctrine = $doctrine;
        $this->serviceContainer = $service_container;
    }

    /**
     * function to sanitize the data
     *
     * @param $arr
     * @return array
     */
    public function sanitarize ($arr) 
    {
        foreach( $arr as $key => $value ) {
          $returnArr[$key] = trim(htmlspecialchars($value));
        }
      return $returnArr;
    }
    /**
     * function to validate the data
     *
     * @param $param
     * @return array
     */
    public function checkDetails ($param)
    {
        try {
            
            $returnData['status'] = false;
            $param['name'] = (isset($param['name'])) ? $param['name'] : "";
            $param['category'] = (isset($param['category'])) ? $param['category'] : "";
            
            //santizing the data
            $returnData = $this->sanitarize($param);
            
            if (!isset($param['name']) || !isset($param['category'] )  ) {
                $returnData['message'] = 'api.missing_parameters';
                return $returnData;
            }

            $returnData['status'] = true;

        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        return $returnData;
    }

    
    /**
     * Private function to generate and sms the otp
     *
     * @param $param
     * @return array
     */
    public function getProductResponse($param)
    {
        try {
            $returnData['status'] = false;
            
            //seraching the product based on params
            $products = $this->doctrine->getRepository('AppBundle:Product')->getProducts($param);
            $resultArray = array();
            $productDetails = array();
            $i = 0;
            foreach ($products as $product) {

                //the productDetails
                $productDetails['Sku'] = (null !== $product['sku']) ? $product['sku'] : '';
                $productDetails['Name'] = (null !== $product['name']) ? $product['name'] : '';
                $productDetails['Description'] = (null !==$product['description']) ? $product['description'] : '';
                $productDetails['level'] = (null !==$product['level']) ? $product['level'] : '';
                $productDetails['taxable'] = (null !==$product['taxable']) ? $product['taxable'] : '';
                $productDetails['unit_price'] = (null !==$product['unit_price']) ? $product['unit_price'] : '';
                $productDetails['quantity_on_hand'] = (null !==$product['quantity_on_hand']) ? $product['quantity_on_hand'] : '';
                $productDetails['type'] = (null !==$product['type']) ? $product['type'] : '';
                $productDetails['reorder_point'] = (null !==$product['reorder_point']) ? $product['reorder_point'] : '';
               
                $resultArray['product'][$i]=$productDetails;
                $i++;
            } 
            //In case no records found
            if(!$resultArray){
               $returnData['message'] = 'api.empty';
                return $returnData; 
            }
            $returnData['status'] = true;
            $returnData['response'] = $resultArray;

        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }

        return $returnData;
    }
}