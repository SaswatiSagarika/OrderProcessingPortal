<?php
/**
 * TaxCode
 *
 * @author Saswati
 *
 * @category Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxCode
 *
 * @ORM\Table(name="TaxCode")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaxCodeRepository")
 */
class TaxCode
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="taxable", type="boolean")
     */
    private $taxable;

    /**
     * @ORM\ManyToOne(targetEntity="TaxRate")
     * @ORM\JoinColumn(name="tax_rate_id", referencedColumnName="id", nullable=false)
     */
    private $taxRate;

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
     * Set name
     *
     * @param string $name
     *
     * @return TaxCode
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
     * Set code
     *
     * @param string $code
     *
     * @return TaxCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set status
     *
     * @param \AppBundle\Entity\Status $status
     *
     * @return TaxCode
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
     * Set taxable
     *
     * @param boolean $taxable
     *
     * @return TaxCode
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
     * Set TaxCode
     *
     * @param \AppBundle\Entity\TaxCode $TaxCode
     *
     * @return TaxCode
     */
    public function setTaxRateId(\AppBundle\Entity\TaxCode $TaxCode)
    {
        $this->TaxCode = $TaxCode;

        return $this;
    }

    /**
     * Get TaxCode
     *
     * @return \AppBundle\Entity\TaxCode
     */
    public function getTaxRateId()
    {
        return $this->TaxCode;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return TaxCode
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
     * @return TaxCode
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

