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
use AppBundle\EventListener\TranslatorInterface;
use AppBundle\Entity\Account;
use AppBundle\Entity\Product;
use AppBundle\Entity\Vendor;

use DOMDocument;

class ValidateService
{

    /**
     * @var Registry
     */
    protected $doctrine;
    
    /**
     * @var translator
     */
    private $translator;

    /**
     * @param Registry $doctrine
     *
     * @return void
     */
    
    public function __construct(Registry $doctrine, $translator)
    {
        $this->doctrine = $doctrine;
        $this->translator = $translator;
    }
    
    /**
     * function to sanitize the data
     *
     * @param array $arr
     *
     * @return array
     */
    public function sanitarize($arr)
    {
        foreach ($arr as $key => $data) {

            $returnArr[$key] = trim(htmlspecialchars($data));
        }
        return $returnArr;
    }

    /**
     * function to validate the data
     *
     * @param array $param
     *
     * @return array
     */
    public function checkDetails($param)
    {
        try {
            $returnData['status'] = false;
           
            //santizing the data
            $returnData = $this->sanitarize($param);
            
            $returnData['status'] = true;
        }
        catch (\Exception $e) {
            $returnData['error'] = $e->getMessage();
        }
        return $returnData;
    }
    
    /**
     * function to validate the data
     *
     * @param array $param
     *
     * @return array
     */
    public function validateOrderDetails($param) 
    {
       try {
            $returnData['status'] = false;
            //check accuont details
            if (!empty($param['APAccountRef'])) {
                $returnData['APAccountRef'] = $this->validateAccountDetails($param['APAccountRef']);
                
                if (false === $returnData['APAccountRef']['status']) {
                   throw new NotFoundHttpException($returnData['APAccountRef']['error']);
                }
            }
            //check product details
            $returnData['Line'] = $this->validateProductDetails($param['Line']);
            if (false === $returnData['Line']['status']) {
                throw new Exception($returnData['Line']['error']);
            }
             //check if the vendor Ref if given
            if ($param['CustomerRef']) {
                $returnData['CustomerRef'] = $this->validateCustomerDetails($param['CustomerRef']);
            
                if (false === $returnData['CustomerRef']['status']) {
                    throw new Exception($returnData['CustomerRef']['error']);
                }
            }
            //check if the vendor Ref if given
            if ($param['VendorRef']) {
                //validate the vendor
                $returnData['VendorRef'] = $this->validateVendorDetails($param['VendorRef']);
            
                if (false === $returnData['VendorRef']['status']) {
                    throw new Exception($returnData['VendorRef']['error']);
                }
            }
            $returnData['status'] = true;
            
        } catch (\Exception $e) {
            $returnData['error'] = $e->getMessage();
        }
        return $returnData; 
    }
    /**
     * function to validate the data
     *
     * @param array $param
     *
     * @return array
     */
    public function validateAccountDetails($param)
    {
        try {
            $status = 'status';
            $returnData[$status] = false;
            
            //santizing the data
            $returnData = $this->sanitarize($param);
            //check if account detail present in db
            $account = $this->doctrine->getRepository('AppBundle:Account')->findOneBy(
                array('accountId' => $param['value'] ));

            
            if (!$account && 'Accounts Payable' !== $account->getAccountType()) {
                throw new Exception('api.invalid_account');
            }

            $returnData[$status] = true;
            
        } catch (\Exception $e) {
            $returnData['error'] = $e->getMessage();
        }
        return $returnData;
    }
     
    /**
     * function to Customer the data
     *
     * @param array $param
     *
     * @return array
     */
    public function validateCustomerDetails($param)
    {
        try {
            
            $returnData['status'] = false;
            //santizing the data
            $returnData = $this->sanitarize($param);
            $customer = $this->doctrine->getRepository('AppBundle:Customer')->findOneBy(array(
                        'customer' => $param['value'] ));
            //checking if customer present or not
            if (!($customer)) {
               throw new Exception('api.invalid_customer');
               
            }
            $returnData['status'] = true;
            
        } catch (\Exception $e) {
            $returnData['error'] = $e->getMessage();
        }
        return $returnData;
    }

     /**
     * function to vendor the data
     *
     * @param array $param
     *
     * @return array
     */
    public function validateVendorDetails($param)
    {
        try {
            
            $returnData['status'] = false;
            //santizing the data
            $returnData = $this->sanitarize($param);
            
            //check if Vendor detail present in db
            $vendor = $this->doctrine->getRepository('AppBundle:Vendor')->findOneBy(array(
                        'vendor' => $param['value'] ));
            if (!isset($vendor)) {
               throw new Exception('api.invalid_vendor');
               
            }
            $returnData['status'] = true;
            
        } catch (\Exception $e) {
            $returnData['error'] = $e->getMessage();
        }
        return $returnData;
    }

     /**
     * function to product the data
     *
     * @param array $param
     *
     * @return array
     */
    public function validateProductDetails($params)
    {
        try {
            $returnData['status'] = false;
            foreach ( $params as $param ) {
                $lineType = $param['DetailType'];
                $itemRef = $param[$lineType];
                $item = $this->doctrine->getRepository('AppBundle:Product')->findOneBy(array(
                      'product' => $itemRef['ItemRef']['value'] ));
                if (!($item)) {
                    throw new Exception($returnData);
                }
                if ( $item->getUnitPrice() != $itemRef['UnitPrice']) {
                    throw new Exception($returnData);
                }
                //if taxcode is provided
                if (!empty($itemRef['TaxCodeRef'])) {
                    
                    //sanitize taxcode data
                    $taxRef = $this->sanitarize($itemRef['TaxCodeRef']);
                    $taxCode = $this->doctrine->getRepository('AppBundle:TaxCode')->findOneBy(array(
                        'name' => $taxRef['value'] ));
                    if( $item->getTaxable() !== $taxCode->getTaxable()){
                        throw new Exception($returnData);
                    }
                }
                
            }
           
            $returnData['status'] = true;
            
        } catch (\Exception $e) {
            $returnData['error'] = $e->getMessage();
        }
        return $returnData;
    }
}