<?php
/**
 * PurchaseOrder
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseOrder
 *
 * @ORM\Table(name="PurchaseOrder")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseOrderRepository")
 */
class PurchaseOrder
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
     * @var int
     *
     * @ORM\Column(name="po_id", type="integer")
     */
    private $poId;

    /**
     * @var int
     *
     * @ORM\Column(name="QB_id", type="integer")
     */
    private $QBId;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="total_amt", type="string", length=45, nullable=false)
     */
    private $totalAmt;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="string", length=45, nullable=false)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity="Term")
     * @ORM\JoinColumn(name="sales_term_id", referencedColumnName="id", nullable=false)
     */
    private $salesTerm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime")
     */
    private $dueDate;

    /**
     * @var string
     *
     * @ORM\Column(name="po_status", type="string", length=45)
     */
    private $poStatus;

     /**
     * @ORM\ManyToOne(targetEntity="CompanyCurrency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
     */
    private $currency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modified_date", type="datetime")
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
     * Set poId
     *
     * @param integer $poId
     *
     * @return PurchaseOrder
     */
    public function setPoId($poId)
    {
        $this->poId = $poId;

        return $this;
    }

    /**
     * Get QBId
     *
     * @return int
     */
    public function getQBId()
    {
        return $this->QBId;
    }

    /**
     * Set QBId
     *
     * @param integer $QBId
     *
     * @return PurchaseOrder
     */
    public function setQBId($QBId)
    {
        $this->QBId = $QBId;

        return $this;
    }

    /**
     * Get poId
     *
     * @return int
     */
    public function getPoId()
    {
        return $this->poId;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\customer  $customer
     *
     * @return PurchaseOrder
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return PurchaseOrder
     */
    public function setAccount(\AppBundle\Entity\Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set totalAmt
     *
     * @param string $totalAmt
     *
     * @return PurchaseOrder
     */
    public function setTotalAmt($totalAmt)
    {
        $this->totalAmt = $totalAmt;

        return $this;
    }

    /**
     * Get totalAmt
     *
     * @return string
     */
    public function getTotalAmt()
    {
        return $this->totalAmt;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return PurchaseOrder
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set salesTerm
     *
     * @param integer $salesTerm
     *
     * @return PurchaseOrder
     */
    public function setSalesTerm($salesTerm)
    {
        $this->salesTerm = $salesTerm;

        return $this;
    }

    /**
     * Get salesTerm
     *
     * @return int
     */
    public function getSalesTerm()
    {
        return $this->salesTerm;
    }

    /**
     * Set dueDate
     *
     *
     * @param \DateTime $dueDate
     *
     * @return PurchaseOrder
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set poStatus
     *
     * @param string $poStatus
     *
     * @return PurchaseOrder
     */
    public function setPoStatus($poStatus)
    {
        $this->poStatus = $poStatus;

        return $this;
    }

    /**
     * Get poStatus
     *
     * @return string
     */
    public function getPoStatus()
    {
        return $this->poStatus;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\CompanyCurrency $currency
     *
     * @return PurchaseOrder
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return PurchaseOrder
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
     * @return PurchaseOrder
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

