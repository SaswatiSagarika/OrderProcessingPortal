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
            if (!empty($param['APAccountRef'])) {
                $returnData['APAccountRef'] = $this->validateAccountDetails($param['APAccountRef']);
                
                if (false === $accountDetails['status']) {
                   throw new NotFoundHttpException($accountDetails['error']);
                }
            }
            $returnData['Line'] = $this->validateProductDetails($param['Line']);
            if (false === $lineDetails['status']) {
                throw new Exception($lineDetails['error']);
            }
            if ($param['CustomerRef']) {
                $returnData['CustomerRef'] = $this->validateCustomerDetails($param['CustomerRef']);
            
                if (false === $customerDetails['status']) {
                    throw new Exception($customerDetails['error']);
                }
            }
            //check if the vendor Ref i given
            if ($param['VendorRef']) {
                //validate the vendor
                $returnData['VendorRef'] = $this->validateVendorDetails($param['VendorRef']);
            
                if (false === $vendorDetails['status']) {
                    throw new Exception($vendorDetails['error']);
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
            
            $account = $this->doctrine->getRepository('AppBundle:Account')->findOneBy(
                array('accountId' => $param['value'] ));

            
            if (!$account && 'Accounts Payable' !== $account->getAccountType()) {
               $message = 'api.invalid_account';
                throw new Exception($message);
                
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

            if (!($customer)) {
               $message= 'api.invalid_customer';
               throw new Exception($message);
               
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
            
            $vendor = $this->doctrine->getRepository('AppBundle:Vendor')->findOneBy(array(
                        'vendor' => $param['value'] ));
            if (!isset($vendor)) {
               $message= 'api.invalid_vendor';
               throw new Exception($message);
               
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