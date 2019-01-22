<?php
/**
 * Command used for Users section to upload csv file.
 *
 * @author Saswati
 *
 * @category Custom CommandTest
 */
namespace Tests\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use AppBundle\Command;

class UpdateAccountCommandTest extends WebTestCase
{
	 /**
     * Function to test the upload:accounts command.
     */
	public function testAccountCommandNew()
	{
		$kernel = $this->createKernel();
		$kernel->boot();
		$application = new Application( $kernel );
		$application->add( new Command\UpdateAccountCommand() );
		$command = $application->find( 'upload:accounts' );
		$commandTester = new CommandTester( $command );
		$commandTester->execute( array( 'command' => $command->getName(), 'name' => 'unittest', 'description' => 'unittest', 'account_number' => '76283749830', 'account_id' => '09999', 'sub_account' => 'AccountsPayable', 'classification_id' => '94', 'account_type_id' => '90', 'currency_id' => 'test', 'status_id' => '1'   ) );
		$this->assertEquals( 0, $commandTester->getStatusCode() );
	}
}
