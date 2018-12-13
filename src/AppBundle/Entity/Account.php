<?php
/**
 * Account
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="Account")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 */
class Account
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="AccountType")
     * @ORM\JoinColumn(name="account_type_id", referencedColumnName="id", nullable=false)
     */
    private $account_type;

    /**
     * @var string
     *
     * @ORM\Column(name="account_number", type="string", length=255, nullable=true, unique=true)
     */
    private $account_number;

    /**
     * @var string
     *
     * @ORM\Column(name="account_id", type="string", length=255, nullable=true, unique=true)
     */
    private $accountId;

    /**
     * @var string
     *
     * @ORM\Column(name="credit_balance", type="string", length=255, nullable=true)
     */
    private $creditBalance;

     /**
     * @ORM\ManyToOne(targetEntity="CompanyCurrency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
     */
    private $currency;

     /**
     * @ORM\ManyToOne(targetEntity="TaxCode")
     * @ORM\JoinColumn(name="tax_code_id", referencedColumnName="id", nullable=false)
     */
    private $taxCode;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_account", type="string", length=255, nullable=true)
     */
    private $subAccount;

    /**
     * @ORM\ManyToOne(targetEntity="SubAccountType")
     * @ORM\JoinColumn(name="sub_account_type", referencedColumnName="id", nullable=false)
     */
    private $subAccountType;

    /**
     * @ORM\ManyToOne(targetEntity="Classification")
     * @ORM\JoinColumn(name="classification_id", referencedColumnName="id", nullable=false)
     */
    private $classification;

    /**
     * @var string
     *
     * @ORM\Column(name="sparse", type="string", length=255, nullable=true, nullable=true)
     */
    private $sparse;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=true, nullable=false)
     */
    private $domain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated_time", type="datetime", nullable=false)
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
     * @return Account
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
     * Set description
     *
     * @param string $description
     *
     * @return Account
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set accountType
     *
     * @param \AppBundle\Entity\AccountType $accountType
     *
     * @return Account
     */
    public function setAccountType(\AppBundle\Entity\AccountType  $accountType)
    {
        $this->accountType = $accountType;

        return $this;
    }

    /**
     * Get accountType
     *
     * @return \AppBundle\Entity\AccountType
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Set accountNumber
     * @param string $accountNumber
     *
     * @return Account
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set accountId
     * @param string $accountId
     *
     * @return Account
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set creditBalance
     *
     * @param string $creditBalance
     *
     * @return Account
     */
    public function setCreditBalance($creditBalance)
    {
        $this->creditBalance = $creditBalance;

        return $this;
    }

    /**
     * Get creditBalance
     *
     * @return string
     */
    public function getCreditBalance()
    {
        return $this->creditBalance;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\CompanyCurrency $currency
     *
     * @return Account
     */
    public function setCurrency(\AppBundle\Entity\CompanyCurrency $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\CompanyCurrency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set taxCode
     *
     * @param \AppBundle\Entity\TaxCode $taxCode
     *
     * @return Account
     */
    public function setTaxCode(\AppBundle\Entity\TaxCode $taxCode)
    {
        $this->taxCode = $taxCode;

        return $this;
    }

    /**
     * Get taxCode
     *
     * @return \AppBundle\Entity\TaxCode
     */
    public function getTaxCode()
    {
        return $this->taxCode;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return Account
     */
    public function setStatus(\AppBundle\Entity\Status $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \AppBundle\Entity\Status
     */
    public function getStatusId()
    {
        return $this->status;
    }

    /**
     * Set subAccount
     *
     * @param \AppBundle\Entity\SubAccountType $subAccount
     *
     * @return Account
     */
    public function setSubAccount(\AppBundle\Entity\SubAccountType $subAccount)
    {
        $this->subAccount = $subAccount;

        return $this;
    }

    /**
     * Get subAccount
     *
     * @return \AppBundle\Entity\SubAccountType
     */
    public function getSubAccount()
    {
        return $this->subAccount;
    }

    /**
     * Set classification
     *
     * @param \AppBundle\Entity\Classification $classification
     *
     * @return Account
     */
    public function setClassification(\AppBundle\Entity\Classification $classification)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return \AppBundle\Entity\Classification
     */
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * Set sparse
     *
     * @param string $sparse
     *
     * @return Account
     */
    public function setSparse($sparse)
    {
        $this->sparse = $sparse;

        return $this;
    }

    /**
     * Get sparse
     *
     * @return string
     */
    public function getSparse()
    {
        return $this->sparse;
    }

    /**
     * Set domain
     *
     * @param string $domain
     *
     * @return Account
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    
    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Account
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
     * @return Account
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
    }
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->lastUpdateDateTime = new \DateTime();
    }
}
