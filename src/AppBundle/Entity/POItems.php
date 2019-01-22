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
     * @ORM\Column(name="item_price", type="string", length=45)
     */
    private $itemPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="taxable_amount", type="string", length=45)
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
     * @param \AppBundle\Entity\Product $item
     *
     * @return POItems
     */
    public function setItem(\AppBundle\Entity\Product $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \AppBundle\Entity\Product
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
     * @param $status
     *
     * @return POItems
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
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

