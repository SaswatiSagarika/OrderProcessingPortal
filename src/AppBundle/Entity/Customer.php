<?php
/**
 * Customer
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="Customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Company")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", nullable=true)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=45, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email_address", type="string", length=45, nullable=true)
     */
    private $emailAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="web_address", type="string", length=45, nullable=true)
     */
    private $webAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_with_jobs", type="string", length=45, nullable=true)
     */
    private $balanceWithJobs;

    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="float", nullable=true)
     */
    private $balance;

    /**
     * @var string
     *
     * @ORM\Column(name="preferred_delivery_method", type="string", length=45, nullable=true)
     */
    private $preferredDeliveryMethod;

    /**
     * @ORM\ManyToOne(targetEntity="CompanyCurrency")
     * @ORM\JoinColumn(name="company_currency_id", referencedColumnName="id", nullable=true)
     */
    private $currency;

    /**
     * @var bool
     *
     * @ORM\Column(name="print_on_check_name", type="string", length=45, nullable=true)
     */
    private $printOnCheckName;

    /**
     * @var string
     *
     * @ORM\Column(name="line1", type="string", length=45, nullable=true)
     */
    private $line1;

    /**
     * @var string
     *
     * @ORM\Column(name="line2", type="string", length=45, nullable=true)
     */
    private $line2;

    /**
     * @var string
     *
     * @ORM\Column(name="line3", type="string", length=45, nullable=true)
     */
    private $line3;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=45, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country_sub_division_code", type="string", length=45, nullable=true)
     */
    private $countrySubDivisionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=45, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=45, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=45, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_id", type="string", length=55)
     */
    private $customer;

    /**
     * @var string
     *
     * @ORM\Column(name="logitude", type="string", length=45, nullable=true)
     */
    private $logitude;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated_time", type="datetime", nullable=true)
     */
    private $lastUpdatedTime;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set companycompany
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return Customer
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return Customer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return String
     * 
     */
    public function __toString(){
        
        return $this->name;
        
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return Customer
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set customer
     *
     * @param string $customer
     *
     * @return Customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set webAddress
     *
     * @param string $webAddress
     *
     * @return Customer
     */
    public function setWebAddress($webAddress)
    {
        $this->webAddress = $webAddress;

        return $this;
    }

    /**
     * Get webAddress
     *
     * @return string
     */
    public function getWebAddress()
    {
        return $this->webAddress;
    }

    /**
     * Set balanceWithJobs
     *
     * @param string $balanceWithJobs
     *
     * @return Customer
     */
    public function setBalanceWithJobs($balanceWithJobs)
    {
        $this->balanceWithJobs = $balanceWithJobs;
        return $this;
    }

    /**
     * Get balanceWithJobs
     *
     * @return Customer
     */
    public function getBalanceWithJobs()
    {
        return $this->balanceWithJobs;
    }
    /**
     * Set balance
     *
     * @param float $balance
     *
     * @return Customer
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set preferredDeliveryMethod
     *
     * @param string $preferredDeliveryMethod
     *
     * @return Customer
     */
    public function setPreferredDeliveryMethod($preferredDeliveryMethod)
    {
        $this->preferredDeliveryMethod = $preferredDeliveryMethod;

        return $this;
    }

    /**
     * Get preferredDeliveryMethod
     *
     * @return string
     */
    public function getPreferredDeliveryMethod()
    {
        return $this->preferredDeliveryMethod;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     *
     * @return Customer
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /** 
     * Set printOnCheckName
     *
     * @param string $printOnCheckName
     *
     * @return Customer
     */
    public function setPrintOnCheckName($printOnCheckName)
    {
        $this->printOnCheckName = $printOnCheckName;

        return $this;
    }

    /**
     * Get printOnCheckName
     *
     * @return string
     */
    public function getPrintOnCheckName()
    {
        return $this->printOnCheckName;
    }

    /**
     * Set line1
     *
     * @param string $line1
     *
     * @return Customer
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;

        return $this;
    }

    /**
     * Get line1
     *
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * Set line2
     *
     * @param string $line2
     *
     * @return Customer
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;

        return $this;
    }

    /**
     * Get line2
     *
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * Set line3
     *
     * @param string $line3
     *
     * @return Customer
     */
    public function setLine3($line3)
    {
        $this->line3 = $line3;

        return $this;
    }

    /**
     * Get line3
     *
     * @return string
     */
    public function getLine3()
    {
        return $this->line3;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set countrySubDivisionCode
     *
     * @param string $countrySubDivisionCode
     *
     * @return Customer
     */
    public function setCountrySubDivisionCode($countrySubDivisionCode)
    {
        $this->countrySubDivisionCode = $countrySubDivisionCode;

        return $this;
    }

    /**
     * Get countrySubDivisionCode
     *
     * @return string
     */
    public function getCountrySubDivisionCode()
    {
        return $this->countrySubDivisionCode;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Customer
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Customer
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set logitude
     *
     * @param string $logitude
     *
     * @return Customer
     */
    public function setLogitude($logitude)
    {
        $this->logitude = $logitude;

        return $this;
    }

    /**
     * Get logitude
     *
     * @return string
     */
    public function getLogitude()
    {
        return $this->logitude;
    }

    
    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Customer
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set lastUpdatedTime
     *
     * @param \DateTime $lastUpdatedTime
     *
     * @return Customer
     */
    public function setLastUpdatedTime($lastUpdatedTime)
    {
        $this->lastUpdatedTime = $lastUpdatedTime;

        return $this;
    }

    /**
     * Get lastUpdatedTime
     *
     * @return \DateTime
     */
    public function getLastUpdatedTime()
    {
        return $this->lastUpdatedTime;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdDate = new \DateTime();
        $this->lastUpdatedTime = new \DateTime();
    }
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->lastUpdatedTime = new \DateTime();
    }
}

