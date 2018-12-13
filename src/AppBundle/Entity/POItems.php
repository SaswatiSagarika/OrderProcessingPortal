<?php
/**
 * POItems
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * POItems
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="POItems")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\POItemsRepository")
 */
class POItems
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
     * @ORM\ManyToOne(targetEntity="PurchaseOrder")
     * @ORM\JoinColumn(name="po_id", referencedColumnName="id", nullable=false)
     */
    private $po;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="item_price", type="string", length=255)
     */
    private $itemPrice;

    /**
     * @ORM\ManyToOne(targetEntity="TaxCode")
     * @ORM\JoinColumn(name="tax_code_id", referencedColumnName="id", nullable=false)
     */
    private $taxCode;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="bill_status", type="string", length=255)
     */
    private $billStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="taxable_amount", type="string", length=255)
     */
    private $taxableAmount;

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
    public function getId(){
        return $this->id;
    }

    /**
     * Set po
     *
     * @param integer $po
     *
     * @return POItems
     */
    public function setPo($po)
    {
        $this->po = $po;

        return $this;
    }

    /**
     * Get po
     *
     * @return int
     */
    public function getPo()
    {
        return $this->po;
    }

    /**
     * Set item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return POItems
     */
    public function setItem(\AppBundle\Entity\Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \AppBundle\Entity\Item
     */
    public function getItemId()
    {
        return $this->item;
    }

    /**
     * Set itemPrice
     *
     * @param string $itemPrice
     *
     * @return POItems
     */
    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;

        return $this;
    }

    /**
     * Get itemPrice
     *
     * @return string
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    /**
     * Set taxCode
     *
     * @param \AppBundle\Entity\TaxCode $taxCode
     *
     * @return POItems
     */
    public function setTaxCode(\AppBundle\Entity\TaxCode$taxCode)
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return POItems
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return POItems
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set billStatus
     *
     * @param string $billStatus
     *
     * @return POItems
     */
    public function setBillStatus($billStatus)
    {
        $this->billStatus = $billStatus;

        return $this;
    }

    /**
     * Get billStatus
     *
     * @return string
     */
    public function getBillStatus()
    {
        return $this->billStatus;
    }

    /**
     * Set taxableAmount
     *
     * @param string $taxableAmount
     *
     * @return POItems
     */
    public function setTaxableAmount($taxableAmount)
    {
        $this->taxableAmount = $taxableAmount;

        return $this;
    }

    /**
     * Get taxableAmount
     *
     * @return string
     */
    public function getTaxableAmount()
    {
        return $this->taxableAmount;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return POItems
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
     * @return POItems
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

