<?php
/**
 * Product
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="Product")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="sku", type="string", length=10, unique=true, nullable=true)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=255, nullable=true)
     */
    private $level;

    /**
     * @var bool
     *
     * @ORM\Column(name="taxable", type="boolean", nullable=true)
     */
    private $taxable;

    /**
     * @var bool
     *
     * @ORM\Column(name="sales_tax_included", type="boolean", nullable=true)
     */
    private $sales_tax_included;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_price", type="string", length=255, nullable=true)
     */
    private $unit_price;

    /**
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="inventory_assest_account_id", referencedColumnName="id", nullable=true)
     */
    private $inventory_assest_account;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $created_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated_time", type="datetime", nullable=true)
     */
    private $last_updated_time;

    /**
     * @ORM\ManyToOne(targetEntity="ItemCategoryType")
     * @ORM\JoinColumn(name="item_category_type_id", referencedColumnName="id", nullable=true)
     */
    private $item_category_type;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity_on_hand", type="integer", nullable=true)
     */
    private $quantity_on_hand;

    /**
     * @var int
     *
     * @ORM\Column(name="reorder_point", type="integer", nullable=true)
     */
    private $reorder_point;

    /**
     * @var string
     *
     * @ORM\Column(name="sales_information", type="string", length=255, nullable=true)
     */
    private $sales_information;

    /**
     * @var string
     *
     * @ORM\Column(name="purchasing_information", type="string", length=255, nullable=true)
     */
    private $purchasing_information;

    /**
     * @var int
     *
     * @ORM\Column(name="cost", type="integer", nullable=true)
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="expense_account_id", referencedColumnName="id", nullable=true)
     */
    private $expense_account;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="prefered_vendor_id", referencedColumnName="id", nullable=true)
     */
    private $prefered_vendor;


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
     * @return Product
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
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return Product
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
     * Set level
     *
     * @param string $level
     *
     * @return Product
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set taxable
     *
     * @param boolean $taxable
     *
     * @return Product
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;

        return $this;
    }

    /**
     * Get taxable
     *
     * @return bool
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * Set sales_tax_included
     *
     * @param boolean $sales_tax_included
     *
     * @return Product
     */
    public function setSalesTaxIncluded($sales_tax_included)
    {
        $this->sales_tax_included = $sales_tax_included;

        return $this;
    }

    /**
     * Get sales_tax_included
     *
     * @return bool
     */
    public function getSalesTaxIncluded()
    {
        return $this->sales_tax_included;
    }

    /**
     * Set unit_price
     *
     * @param string $unit_price
     *
     * @return Product
     */
    public function setUnitPrice($unit_price)
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    /**
     * Get unit_price
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\Type $type
     *
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set created_date
     *
     * @param \DateTime $created_date
     *
     * @return Product
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
     * Get created_date
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * Set last_updated_time
     *
     * @param \DateTime $last_updated_time
     *
     * @return Product
     */
    public function setLastUpdatedTime($last_updated_time)
    {
        $this->last_updated_time = $last_updated_time;

        return $this;
    }

    /**
     * Get last_updated_time
     *
     * @return \DateTime
     */
    public function getLastUpdatedTime()
    {
        return $this->last_updated_time;
    }

    /**
     * Set item_category_type
     *
     * @param \AppBundle\Entity\ItemCategoryType $item_category_type
     *
     * @return Product
     */
    public function setItemCategoryType(\AppBundle\Entity\ItemCategoryType $item_category_type)
    {
        $this->item_category_type = $item_category_type;

        return $this;
    }

    /**
     * Get item_category_type
     *
     * @return \AppBundle\Entity\ItemCategoryType
     */
    public function getItemCategoryType()
    {
        return $this->item_category_type;
    }

    /**
     * Set quantityOnHand
     *
     * @param integer $quantityOnHand
     *
     * @return Product
     */
    public function setQuantityOnHand($quantityOnHand)
    {
        $this->quantityOnHand = $quantityOnHand;

        return $this;
    }

    /**
     * Get quantityOnHand
     *
     * @return int
     */
    public function getQuantityOnHand()
    {
        return $this->quantityOnHand;
    }

    /**
     * Set reorderPoint
     *
     * @param integer $reorderPoint
     *
     * @return Product
     */
    public function setReorderPoint($reorderPoint)
    {
        $this->reorderPoint = $reorderPoint;

        return $this;
    }

    /**
     * Get reorderPoint
     *
     * @return int
     */
    public function getReorderPoint()
    {
        return $this->reorderPoint;
    }

    /**
     * Set invntoryAssetAccount
     *
     * @param \AppBundle\Entity\Account $invntoryAssetAccount
     *
     * @return Product
     */
    public function setInvntoryAssetAccount( \AppBundle\Entity\Account $invntoryAssetAccount)
    {
        $this->invntoryAssetAccount = $invntoryAssetAccount;

        return $this;
    }

    /**
     * Get invntoryAssetAccount
     *
     * @return \AppBundle\Entity\Account
     */
    public function getInvntoryAssetAccount()
    {
        return $this->invntoryAssetAccount;
    }

    /**
     * Set salesInformation
     *
     * @param string $salesInformation
     *
     * @return Product
     */
    public function setSalesInformation($salesInformation)
    {
        $this->salesInformation = $salesInformation;

        return $this;
    }

    /**
     * Get salesInformation
     *
     * @return string
     */
    public function getSalesInformation()
    {
        return $this->salesInformation;
    }

    /**
     * Set purchasingInformation
     *
     * @param string $purchasingInformation
     *
     * @return Product
     */
    public function setPurchasingInformation($purchasingInformation)
    {
        $this->purchasingInformation = $purchasingInformation;

        return $this;
    }

    /**
     * Get purchasingInformation
     *
     * @return string
     */
    public function getPurchasingInformation()
    {
        return $this->purchasingInformation;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     *
     * @return Product
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set expense_account
     *
     * @param \AppBundle\Entity\Account $expense_account
     *
     * @return Product
     */
    public function setExpenseAccount(\AppBundle\Entity\Account $expense_account)
    {
        $this->expense_account = $expense_account;

        return $this;
    }

    /**
     * Get expense_account
     *
     * @return \AppBundle\Entity\Account
     */
    public function getExpenseAccount()
    {
        return $this->expense_account;
    }

    /**
     * Set prefered_vendor
     *
     * @param \AppBundle\Entity\Vendor $prefered_vendor
     *
     * @return Product
     */
    public function setPreferedVendor(\AppBundle\Entity\Vendor $prefered_vendor)
    {
        $this->prefered_vendor = $prefered_vendor;

        return $this;
    }

    /**
     * Get prefered_vendor
     *
     * @return \AppBundle\Entity\Vendor
     */
    public function getPreferedVendor()
    {
        return $this->prefered_vendor;
    }
}

