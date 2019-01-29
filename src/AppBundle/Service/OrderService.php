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
use AppBundle\Service\DefaultDataService;
use AppBundle\Entity\PurchaseOrder;
use AppBundle\Entity\POItems;
// use AppBundle\Entity\POItems;

class OrderService
{

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var dataService
     */
    private $dataService;

    /**
     * @var mailer
     */
    private $mailer;

    /**
     * @var mailer
     */
    private $translator;

    /**
     * @param Registry $doctrine
     *
     * @return void
     */
    
    public function __construct($doctrine, $dataService, $mailer, $translator)
    {
        $this->doctrine = $doctrine;
        $this->dataService = $dataService;
        $this->mailer = $mailer;
        $this->translator = $translator;
    }
    
    /**
     * function to sanitize the data
     *
     * @param array $arr
     *
     * @return array
     */
    public function placeCustomerOrderDetails($param)
    {
        try 
        {
            $returnData['status'] = false;
            $em = $this->doctrine->getEntityManager();
            $orderId = time();
            $orderRef = new PurchaseOrder();
            $orderRef->setPoId($orderId)
                    ->setTotalAmt($param['TotalAmt'])
                    ->setPoStatus('New')
                    ->setNotes($param['Memo']?$param['Memo']:'');
            //check if account is given
            if($param['APAccountRef']) {
                $account = $this->doctrine->getRepository('AppBundle:Account')->findOneBy(array(
                            'accountId' => $param['APAccountRef']['value'] ));

                $orderRef->setAccount($account);
            }
            //check if customer is given
            $customer = $this->doctrine->getRepository('AppBundle:Customer')->findOneBy(array('customer' => $param['CustomerRef']['value']));
            //check if term is given
            if(!$param['TermRef']) {
               $term = 'Due on receipt';
  
            }
           $ $term = $this->doctrine->getRepository('AppBundle:Term')->findOneBy(array('name' => $ $term));
            $orderRef->setCustomer($customer)
                ->setDueDate(new \DateTime('now'))
                ->setSalesTerm($term);
            if (!$param['CurrecnyRef']) {
                $currency = 'USD';
            }

            $currecny = $this->doctrine->getRepository('AppBundle:CompanyCurrency')->findOneBy(array('name' => $currency));
            $orderRef->setCurrency($currecny);
            //create the PO Item records
            $this->createOrderItems($param['Line'], $orderRef);
            
            $createRecord = $this->dataService->createInvoice($param);
            $quick_id = $createRecord['message']->Id;
            if (false === $createRecord['status']) {
                $returnData['message'] = $createRecord;
                return $returnData;
            } 

            $orderRef->setQBId($quick_id);

            $em->persist($orderRef);

            $em->flush();
            //send mail to vendor
            $sendMail = $this->mailer->mailToVendor($param['Line']);
            if (false === $sendMail['status']) {
                $returnData['message'] = $sendMail['errorMessage'];
                return $returnData;
            }
            $returnData['orderID'] = $orderId;
            $returnData['originalAmount'] = $param['TotalAmt'];
            $returnData['quickbooksId'] = $quick_id;
            $returnData['status'] = true;
            $returnData['message'] = "order successfully placed.";
            
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
            return $returnData;

        }
        return $returnData;
    }
    
    public function createOrderItems($params, $order) 
    {
        try
        {
            $em = $this->doctrine->getEntityManager();
            
            foreach ($params as $param) {

                $product = $param['SalesItemLineDetail'];
                $itemRef = new POItems();
                $itemRef->setPo($order)
                        ->setQuantity($product['Qty'])
                        ->setStatus('Active')
                        ->setItemPrice($product['UnitPrice']);

                $item = $this->doctrine->getRepository('AppBundle:Product')->findOneBy(array(
                        'product' => $product['ItemRef']['value'] ));
                if( $product['TaxCodeRef']['value'] ){
                    $taxCode = $this->doctrine->getRepository('AppBundle:TaxCode')->findOneBy(array(
                    'name' => $product['TaxCodeRef']['value'] ));
                    $itemRef->setTaxCode($taxCode );
                }

                                
                $itemRef->setItem($item)
                    ->setTaxableAmount($product['Qty']);  

                $em->persist($itemRef);
            }
            $em->flush();
        } catch (\Exception $e) {
            $returnData['errorMessage'] = $e->getMessage();
            return $returnData;
        }

        return array('status' => true);
    }


     /**
     * Private function to order List
     *
     * @param array $param
     *
     * @return array
     */
    public function getOrderHistoryDetails($param = array())
    {
        try {
            $returnData['status'] = false;
            //seraching the product based on params
            $orders       = $this->doctrine->getRepository('AppBundle:PurchaseOrder')->getOrderDetails($param);
            $resultArray    = array();
            $orderDetails = array();
            $i              = 0;
            foreach ($orders as $order) {

                //the orderDetails
                $orderDetails['poId']              = $order['poId'];
                $orderDetails['customer']          = $order['customer'];
                $orderDetails['account']           = $order['account'];
                $orderDetails['salesTerm']         = $order['salesTerm'];
                $orderDetails['totalAmt']          = $order['totalAmt'] ;
                $orderDetails['notes']             = $order['notes'];
                $orderDetails['dueDate']           = $order['dueDate'];
                $orderDetails['currency']          = $order['currency'];
                
                $resultArray['order'][$i] = $orderDetails;
                $i++;
            }
            
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