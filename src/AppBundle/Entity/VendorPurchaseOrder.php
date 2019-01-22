<?php
/**
 * VendorPurchaseOrder
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VendorPurchaseOrder
 *
 * @ORM\Table(name="VendorPurchaseOrder")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VendorPurchaseOrderRepository")
 */
class VendorPurchaseOrder
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
     * @ORM\Column(name="VendorPurchaseOrder_id", type="integer")
     */
    private $VendorPurchaseOrder;

    /**
     * @var int
     *
     * @ORM\Column(name="qb_VendorPO_id", type="integer")
     */
    private $qbVendorPO;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id", nullable=false)
     */
    private $Vendor;

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
     * @ORM\Column(name="VendorPurchaseOrder_status", type="string", length=45)
     */
    private $VendorPurchaseOrderStatus;

     /**
     * @ORM\ManyToOne(targetEntity="CompanyCurrency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id", nullable=false)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="exchange_rate", type="string", length=45)
     */
    private $exchangeRate;

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
     * Set VendorPurchaseOrder
     *
     * @param integer $VendorPurchaseOrder
     *
     * @return VendorPurchaseOrder
     */
    public function setVendorPurchaseOrder($VendorPurchaseOrder)
    {
        $this->VendorPurchaseOrder = $VendorPurchaseOrder;

        return $this;
    }

    /**
     * Get qbVendorPurchaseOrder
     *
     * @return int
     */
    public function getQBVendorPurchaseOrder()
    {
        return $this->qbVendorPurchaseOrder;
    }

    /**
     * Set qbVendorPurchaseOrder
     *
     * @param integer $qbVendorPurchaseOrder
     *
     * @return VendorPurchaseOrder
     */
    public function setQBVendorPurchaseOrder($qbVendorPurchaseOrder)
    {
        $this->qbVendorPurchaseOrder = $qbVendorPurchaseOrder;

        return $this;
    }

    /**
     * Get VendorPurchaseOrder
     *
     * @return int
     */
    public function getVendorPurchaseOrder()
    {
        return $this->VendorPurchaseOrder;
    }

    /**
     * Set vendor
     *
     * @param \AppBundle\Entity\Vendor  $vendor
     *
     * @return VendorPurchaseOrder
     */
    public function setVendor(\AppBundle\Entity\Vendor $vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return \AppBundle\Entity\Vendor 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set account
     *
     * @param \AppBundle\Entity\Account $account
     *
     * @return VendorPurchaseOrder
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
     * @return VendorPurchaseOrder
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
     * @return VendorPurchaseOrder
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
     * @return VendorPurchaseOrder
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
     * @return VendorPurchaseOrder
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
     * Set VendorPurchaseOrderStatus
     *
     * @param string $VendorPurchaseOrderStatus
     *
     * @return VendorPurchaseOrder
     */
    public function setVendorPurchaseOrderStatus($VendorPurchaseOrderStatus)
    {
        $this->VendorPurchaseOrderStatus = $VendorPurchaseOrderStatus;

        return $this;
    }

    /**
     * Get VendorPurchaseOrderStatus
     *
     * @return string
     */
    public function getVendorPurchaseOrderStatus()
    {
        return $this->VendorPurchaseOrderStatus;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\CompanyCurrency $currency
     *
     * @return VendorPurchaseOrder
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
     * Set exchangeRate
     *
     * @param string $exchangeRate
     *
     * @return VendorPurchaseOrder
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;

        return $this;
    }

    /**
     * Get exchangeRate
     *
     * @return string
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }
    
    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return VendorPurchaseOrder
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
     * @return VendorPurchaseOrder
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
