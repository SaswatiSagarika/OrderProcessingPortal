<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SubAccountType
 *
 * @ORM\Table(name="SubAccountType")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubAccountTypeRepository")
 */
class SubAccountType
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
     * @ORM\ManyToOne(targetEntity="Classification")
     * @ORM\JoinColumn(name="classification_id", referencedColumnName="id", nullable=true)
     */
    private $classification;

    /**
     * @ORM\ManyToOne(targetEntity="AccountType")
     * @ORM\JoinColumn(name="account_type_id", referencedColumnName="id", nullable=true)
     */
    private $accountType;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true)
     */
    private $status;
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
     * @return String
     * 
     */
    public function __toString(){
        
        return $this->name;
        
    }

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
     * @return SubAccountType
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
     * @return SubAccountType
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
     * Set classification
     *
     * @param \AppBundle\Entity\Classification $classification
     *
     * @return SubAccountType
     */
    public function setClassification($classification)
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
     * Set accountType
     *
     * @param \AppBundle\Entity\AccountType $accountType
     *
     * @return SubAccountType
     */
    public function setAccountType($accountType)
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
     * Set status
     *
     * @param integer $status
     *
     * @return SubAccountType
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return SubAccountType
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
     * @return SubAccountType
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

