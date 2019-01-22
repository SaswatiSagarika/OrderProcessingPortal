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

class ProductService
{

    /**
     * @var Registry
     */
    protected $doctrine;
    
    /**
     * @param Registry $doctrine
     *
     * @return void
     */
    
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }  
    
    /**
     * Private function to generate and sms the otp
     *
     * @param array $param
     *
     * @return array
     */
    public function getProductResponse($param = array())
    {
        try {
            $returnData['status'] = false;
            //seraching the product based on params
            $products       = $this->doctrine->getRepository('AppBundle:Product')->getProducts($param);
            $resultArray    = array();
            $productDetails = array();
            $categorytDetails = array();
            $i              = 0;
            $j              = 0;
            foreach ($products as $product) {

                //the productDetails
                $productDetails['sku']              = $product['sku'];
                $productDetails['name']             = $product['name'];
                $productDetails['description']      = $product['description'];
                $productDetails['level']            = $product['level'];
                $productDetails['taxable']          = $product['taxable'] ;
                $productDetails['unit_price']       = $product['unit_price'];
                $productDetails['quantity_on_hand'] = $product['quantity_on_hand'];
                $productDetails['type']             = $product['type'];
                $productDetails['reorder_point']    = $product['reorder_point'];
                $productDetails['image']            = $product['image'];
                $productDetails['product_id']       = $product['product'];
                

                if (! in_array($product['category'], $categorytDetails)) {
                    array_push($categorytDetails, $product['category']);
                }
                $resultArray['product'][$i] = $productDetails;
                $i++;
            }
            $resultArray['filter']['category'] = $categorytDetails;
            //In case no records found
            if (!$resultArray) {
                $returnData['message'] = 'api.empty';
                return $returnData;
            }
            $returnData['status']   = true;
            $returnData['response'] = $resultArray;
            
        }
        catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
        }
        
        return $returnData;
    }
}