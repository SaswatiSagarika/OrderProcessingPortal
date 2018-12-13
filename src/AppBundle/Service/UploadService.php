<?php

/**
 * Description of upload service  to upload data
 * @author Saswati
 * 
 * @category Service
 *
 */
namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use QuickBooksOnline\API\DataService\DataService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use AppBundle\Entity\Account;
use AppBundle\Entity\AccountType;
use AppBundle\Entity\SubAccountType;
use AppBundle\Entity\Classification;
use AppBundle\Entity\TaxCode;
use AppBundle\Entity\CompanyCurrency;
use AppBundle\Entity\Vendor;
use AppBundle\Service\DefaultService;
use AppBundle\Entity\Company;
use AppBundle\Entity\Term;
use AppBundle\Entity\ItemCategoryType;
use AppBundle\Entity\Type;
use AppBundle\Entity\Product;

class UploadService
{

    /**
     * @var serviceContainer
     */
    protected $serviceContainer;

    /**
     * @var Registry
     */
    protected $doctrine;
    /**
     * @var dataservice
     */
    private $dataservice;
    /**
     * @param $doctrine
     *
     * @return void
     */

    public function __construct($doctrine, $dataservice, $service_container) {
        $em = $doctrine;
        $this->dataservice = $dataservice;
        $this->serviceContainer = $service_container;
    }
   

    /**
     * Function to upload the account data
     * @return var
     *
     **/
    public function uploadAccount()
    {   
        try {
            //getting account data
            $data = $this->dataservice->getData('Account'); 
            if(!$data){
                throw new \NotFoundHttpException("no data found");
            }

            $accounts =$data['data'];
           
            $em = $this->serviceContainer->get('doctrine.orm.entity_manager');
            // get status value
            $active = $em->getRepository('AppBundle:Status')->findOneBy(array('name' => 'ACTIVE'));
            $inactive = $em->getRepository('AppBundle:Status')->findOneBy(array('name' => 'INACTIVE'));
            
            foreach ($accounts as $account) {
                
                //if account is already present
                $accountRef = $em->getRepository('AppBundle:Accoount')->findOneBy(array('accountId' => $$account->Id));
                
                //if account is not present create new record
                if (empty($accountRef)) {

                    $accountRef = new Account;
                }
                
                $accountRef->setName($account->FullyQualifiedName)
                         ->setDescription($account->Description)
                         ->setAccountNumber($account->AcctNum)
                         ->setAccountId($account->Id)
                         ->setCreditBalance($account->CurrentBalance)
                         ->setSparse($account->sparse)
                         ->setDomain($account->domain);

                if (true === $account->Active) {
                    $accountRef->setStatus($active);
                } else {
                    $accountRef->setStatus($inactive);
                }

                //check if classification is present in the classification table
                $classification = $this->addedNewUpdate('Classification',$account->Classification, $active);
                $accountRef->setClassification($classification);

                $data['classification'] = $classification;
                $data['type'] = $account->AccountType;
                
                $type = $this->addedNewUpdate('AccountType', $data, $active);
                $accountRef->setAccountType($$type);

                $data['AccountSubType'] = $account->AccountSubType;
                $data['type'] = $type;
                $subType = $this->addedNewUpdate('AccountSubType', $data, $active);
                $accountRef->setSubAccount($subType);

                $currency = $this->addedNewUpdate('CompanyCurrency', $account->CurrencyRef, $active);
                $accountRef->setCurrency($currency);

                $taxcode = $this->addedNewUpdate('TaxCode', $account->TaxCodeRef, $active);               
                $accountRef->setTaxCode($taxcode); 
               
                $em->persist($accountRef);
            }
           
            $em->flush();   
        } catch (\Exception $e) {
            
            $returnData['errorMessage'] = $e->getMessage();
           
        }
        $returnData['sucuess'] = "accounts uploaded";
        return $returnData;
    }

    /**
     * Function to upload the item data
     * @return var
     *
     **/
    public function uploadProducts()
    {   
        try {
            $data = $this->dataservice->getData('Item'); 
            if(!$data){
                throw new \NotFoundHttpException("no data found");
            }
            $items =$data['data'];
           
            $em = $this->serviceContainer->get('doctrine.orm.entity_manager');
            // get status value
            $active = $em->getRepository('AppBundle:Status')->findOneBy(array('name' => 'ACTIVE'));
            $inactive = $em->getRepository('AppBundle:Status')->findOneBy(array('name' => 'INACTIVE'));
            
            foreach ($items as $item) {

                $itemRef = $em->getRepository('AppBundle:Product')->findOneBy(array('sku' => $item->Sku));
                if (empty($itemRef)) {
                    $itemRef = new Product;
                }

                $itemRef->setName($item->Name)
                         ->setSku($item->Sku)
                         ->setDescription($item->Description)
                         ->setLevel($item->Level)
                         ->setTaxable($item->Taxable)
                         ->setQuantityOnHand($item->QtyOnHand)
                         ->setReorderPoint($item->ReorderPoint)
                         ->setUnitPrice($item->UnitPrice)
                         ->setPurchasingInformation($item->PurchaseDesc)
                         ->setCost($item->PurchaseCost);

                if (!empty($item->SalesTaxIncluded)) {
                    $itemRef->setSalesTaxIncluded(false);
                } else {
                    $itemRef->setSalesTaxIncluded($item->SalesTaxIncluded);
                }

                if (true ===($item->Taxable)) {
                    $itemRef->setTaxable(1);
                } else {
                    $itemRef->setTaxable(0);
                }                
                if (true === $item->Active) {
                    $itemRef->setStatus($active);
                } else {
                    $itemRef->setStatus($inactive);
                }

                $vendor = $em->getRepository('AppBundle:Vendor')->findOneBy(array('vendorid' => $item->PrefVendorRef));
                $itemRef->setPreferedVendor($vendor);

                $asset = $em->getRepository('AppBundle:Account')->findOneBy(array('accountId' => $item->AssetAccountRef));
                $itemRef->setInvntoryAssetAccount($asset);

                $expense = $em->getRepository('AppBundle:Account')->findOneBy(array('accountId' => $item->ExpenseAccountRef));
                $itemRef->setExpenseAccount($expense);

                //setting ItemCategoryType ref 
                $cat = $this->addedNewUpdate('ItemCategoryType', $item->ItemCategoryType, $active);
                $itemRef->setItemCategoryType($cat);

                //setting Typeref 
                $type = $this->addedNewUpdate('Type', $item->Type, $active);
                $itemRef->setType($type);
                // persist the item data
                $em->persist($itemRef);
            }
           
            $em->flush();  

        } catch (\Exception $e) {
            
            $returnData['errorMessage'] = $e->getMessage();
           
        }
        $returnData['sucuess'] = "items uploaded";
        return $returnData;
    }

   /**
     * Function to upload the vendor data
     * @return var
     *
     **/
    public function uploadVendors()
    {   
        try {
            $data = $this->dataservice->getData('Vendor'); 
            if(!$data){
                throw new \NotFoundHttpException("no data found");
            }
            $vendors =$data['data'];
           
            $em = $this->serviceContainer->get('doctrine.orm.entity_manager');
            // get status value
            $active = $em->getRepository('AppBundle:Status')->findOneBy(array('name' => 'ACTIVE'));
            $inactive = $em->getRepository('AppBundle:Status')->findOneBy(array('name' => 'INACTIVE'));
            
            foreach ($vendors as $vendor) {

                $vendorRef = $em->getRepository('AppBundle:Vendor')->findOneBy(array('name' => $vendor->name));
                if (empty($vendorRef)) {
                    $vendorRef = new Vendor;
                }

                $vendorRef->setName($vendor->DisplayName)
                         ->setBalance($vendor->Balance)
                         ->setVendor1099($vendor->Vendor1099)
                         ->setAccountNumber($vendor->AcctNum);

                if (!empty($vendor->Vendor1099)) {
                    $vendorRef->setVendor1099(false);
                } else {
                    $vendorRef->setVendor1099($vendor->Vendor1099);
                }
                
                if (!empty($vendor->PrimaryPhone)) {
                    $vendorRef->setPhone($vendor->PrimaryPhone->FreeFormNumber);
                }

                if (!empty($vendor->PrimaryEmailAddr)) {
                    $vendorRef->setEmailAddress($vendor->PrimaryEmailAddr->Address);
                }

                if (!empty($vendor->WebAddr)) { 
                    $vendorRef->setWebAddress($vendor->WebAddr->URI);
                }

                if (!empty($vendor->BillAddr)) { 
                    $vendorRef->setLine1($vendor->BillAddr->Line1)
                         ->setCity($vendor->BillAddr->City)
                         ->setCountrySubDivisionCode($vendor->BillAddr->CountrySubDivisionCode)
                         ->setPostalCode($vendor->BillAddr->PostalCode)
                         ->setLatitude($vendor->BillAddr->Lat)
                         ->setLogitude($vendor->BillAddr->Long);
                }

                if (true === $vendor->Active) {
                    $vendorRef->setStatus($active);
                } else {
                    $vendorRef->setStatus($inactive);
                }

                //setting CompanyNameref 
                $company = $this->addedNewUpdate('Company', $vendor->CompanyName, $active);
                $vendorRef->setCompany($company);

                //setting TermRef 
                $term = $this->addedNewUpdate('Term', $vendor->TermRef, $active);
                $vendorRef->setTerm($term);

                 //setting CurrencyRef 
                $current = $this->addedNewUpdate('CompanyCurrency', $vendor->CurrencyRef, $active);
                $vendorRef->setCurrency($currency);

                 //setting TaxCoderef 
                $taxcode = $this->addedNewUpdate('TaxCode', $vendor->TaxCodeRef, $active);
                $vendorRef->setTax($taxcode); 
               
                $em->persist($vendorRef);
            }
           
            $em->flush();   
        } catch (\Exception $e) {
            
            $returnData['errorMessage'] = $e->getMessage();
            
        }
        $returnData['sucuess'] = "vendors uploaded";
        return $returnData;
    }

    /**
     * Function to create the data
     * @return var
     *
     **/
    public function addedNewUpdate($table, $data,$active)
    {   
        try {

            $em = $this->serviceContainer->get('doctrine.orm.entity_manager');

            //check if the data is present in the table and create new record if data is absent
            switch ($table) {
                case 'TaxCode':
                    $returnData = $em->getRepository('AppBundle:TaxCode')->findOneBy(array('name' => $data));
                    if (empty($returnData) && Null !== $data) {
                        $taxcodeNew = new TaxCode;
                        $taxcodeNew->setStatus($active)
                                    ->setCode($data)
                                    ->setName($data);
                        $em->persist($taxcodeNew);
                        $returnData = $taxcodeNew;
                    }

                    break;
                case 'CompanyCurrency':
                    $returnData = $em->getRepository('AppBundle:CompanyCurrency')->findOneBy(array('name' =>  $data));
                    if (empty($returnData) && Null !== $data) {
                        $currencyNew = new CompanyCurrency;
                        $currencyNew->setStatus($active)
                                    ->setCode($data)
                                    ->setName( $data);
                        $em->persist($currencyNew);
                        $returnData = $currencyNew;
                        
                    }
                    break;
                case 'Term':
                    $returnData = $em->getRepository('AppBundle:Term')->findOneBy(array('name' => $data));

                    if(empty($returnData) && Null !== $data) {
                        
                        $termType = new Term;
                        $termType->setStatus($active)
                                ->setName($data);
                        $em->persist($termType);

                        $returnData = $termType;
                    }
                    break;
                case 'Company':
                    $returnData = $em->getRepository('AppBundle:Company')->findOneBy(array('name' => $data));
                    if(empty($returnData)  && Null !== $data) {
                        
                        $companyNew = new Company;
                        $companyNew->setcompanyCode($data)
                                ->setName($data);

                        $em->persist($companyNew);
                        $returnData = $companyNew;
                    }
                    break;
                case 'Type':
                    $returnData = $em->getRepository('AppBundle:Type')->findOneBy(array('code' => $data));
                    if (empty($returnData) && Null !== $data) {
                        $typeNew = new Type;
                        $typeNew->setDescription($data)
                                    ->setCode($data);
                        $em->persist($typeNew);
                        $returnData = $typeNew;
                    }
                    break;
                case 'ItemCategoryType':
                    $returnData = $em->getRepository('AppBundle:ItemCategoryType')->findOneBy(array('name' => $data));
                    if (empty($returnData) && Null !== $data) {
                        $catNew = new ItemCategoryType;
                        $catNew->setStatus($active)
                                    ->setCode($data)
                                    ->setName($data);
                        $em->persist($catNew);
                        $returnData  = $catNew;
                    }
                    break; 
                case 'Classification':
                    $returnData = $em->getRepository('AppBundle:Classification')->findOneBy(array('name' => $data));
                    if (empty($returnData) && Null !== $data) {
                        $catNew = new Classification;
                        $catNew->setStatus($active)
                                    ->setCode($data)
                                    ->setName($data);
                        $em->persist($catNew);
                        $returnData  = $catNew;
                    }
                    break;
                case 'AccountType':
                    $returnData = $em->getRepository('AppBundle:AccountType')->findOneBy(array('name' => $data));
                    if (empty($returnData)) {
                        $accountType = new AccountType;
                        $accountType->setStatus($active)
                            ->setName($data['type'])
                            ->setCode($data['type'])
                            ->setCassification($data['classification']);
                        $em->persist($accountType);
                        $returnData = $accountType;
                    }
                    break; 
                case 'SubAccountType':
                     $returnData = $em->getRepository('AppBundle:SubAccountType')->findOneBy(array('name' =>  $data));

                    if (empty($returnData)){
                        $accountSubType = new SubAccountType;
                        $accountSubType->setStatus($active)
                                    ->setClassification($data['classification'])
                                    ->setDescription($data['AccountSubType'])
                                    ->setName( $data['AccountSubType'])
                                    ->setAccountType($$data['type']);
                        $em->persist($accountSubType);
                         
                        $returnData = $accountSubType;
                    }
                    break;     
                default:
                    $returnData = 'not valid case';
                    break; 
            }
            $em->flush();   
        } catch (\Exception $e) {
            
            $returnData['errorMessage'] = $e->getMessage();
            
        }
            
        return $returnData;
    }


}

