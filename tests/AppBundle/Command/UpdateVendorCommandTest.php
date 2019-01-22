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

class UpdateVendorCommandTest extends WebTestCase
{
	 /**
     * Function to test the upload:vendors command.
     */
	public function testAccountCommandNew()
	{
		$kernel = $this->createKernel();
		$kernel->boot();
		$application = new Application( $kernel );
		$application->add( new Command\UpdateVendorCommand() );
		$command = $application->find( 'upload:vendors' );
		$commandTester = new CommandTester( $command );
		$commandTester->execute( array( 'command' => $command->getName(), 'company_id' => '1', 'status_id' => '1', 'tax_code_id' => '91', 'term_id' => '1', 'company_currency_id' => '91', 'name' => 'test', 'phone' => '12345657454', 'email_address' => 'teste@rmak.co', 'web_address' => '', 'balance' => '2334.03', 'account_number' => '76283749830', 'vendor1099' => '1', 'line1' => 'rff', 'line2' => 'ff', 'line3' => 'srf', 'city' => 'rferf', 'country_sub_division_code' => '32', 'postal_code' => '123412', 'country' => 'US', 'latitude' => '12.321', 'logitude' => '12.423', 'vendor_id' => '011'   ) );
		$this->assertEquals( 0, $commandTester->getStatusCode() );
	}
}
