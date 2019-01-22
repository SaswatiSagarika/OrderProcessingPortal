<?php
namespace Tests\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use AppBundle\Command;

class UpdateProductCommandTest extends WebTestCase
{
	public function testAccountCommandNew()
	{
		$kernel = $this->createKernel();
		$kernel->boot();
		$application = new Application( $kernel );
		$application->add( new Command\UpdateProductCommand() );
		$command = $application->find( 'upload:products' );
		$commandTester = new CommandTester( $command );
		$commandTester->execute( array( 'command' => $command->getName(), 'name' => 'unittest', 'description' => 'unittest', 'status_id' => '1', 'sku' => '42409999', 'type_id' => '22', 'inventory_assest_account_id' => '94', 'unit_price' => '90.00', 'currency_id' => 'test', 'quantity_on_hand' => '111'   ) );
		$this->assertEquals( 0, $commandTester->getStatusCode() );
	}
}
