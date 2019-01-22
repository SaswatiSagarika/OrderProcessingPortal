<?php
/**
 * AccountType
 *
 * @author Saswati
 *
 * @category EntityTest
 */
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\AccountType;

class AccountTypeTest extends \PHPUnit\Framework\TestCase
{
    private $object;
    protected function setUp()
    {
        $this->object = new AccountType();
    }
   
    /**
    *
     */
    public function testgetId()
    {
        $this->assertEquals( '1', $this->object->getId());
    }

    /**
    *
     */
    public function testgetName()
    {
        $this->assertEquals( 'Accounts Payable', $this->object->getName());
    }

    /**
    *
     */
    public function testgetCode()
    {
        $this->assertEquals( 'Accounts Payable', $this->object->getCode());
    }

    /**
    *
     */
    public function testgetCassification()
    {
        $this->assertEquals(  '91', $this->object->getCassification());
    }

    /**
    *
     */
    public function testgetStatus()
    {
        $this->assertEquals( '1', $this->object->getStatus());
    }

    /**
    *
     */
    public function testgetCreatedDate()
    {
        $this->assertEquals( null, $this->object->getCreatedDate());
    }

    /**
    *
     */
    public function testgetLastUpdatedTime()
    {
        $this->assertEquals( null, $this->object->getLastUpdatedTime());
    }
    
}

