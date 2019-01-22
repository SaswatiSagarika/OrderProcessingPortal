<?php
// tests/AppBundle/Repository/ProductRepositoryTest.php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetProducts()
    {
        $products = $this->entityManager
            ->getRepository(Product::class)
            ->getProducts('Concrete')
        ;

        $this->assertCount(1, $products);
    }

    public function testGetVendorDetail()
    {
        $products = $this->entityManager
            ->getRepository(Product::class)
            ->getVendorDetail(' Concrete')
        ;

        $this->assertCount(1, $products);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}