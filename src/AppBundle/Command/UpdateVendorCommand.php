<?php
/**
 * Command used for Vendors section to upload csv file.
 *
 * @author Saswati
 *
 * @category Custom Command
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateVendorCommand extends ContainerAwareCommand
{
    /**
     * Function to set the name, description and argument for the upload:vendors command.
     */
    protected function configure()
    {
        $this
            ->setName('upload:vendors')
            ->setDescription('create new products in users table')
        ;
    }
    /**
     * Function to execute the upload:vendors command to upload to .
     *
     *@param InputInterface $input
     *@param OutputInterface $output
     *
     *@return $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $container = $this->getContainer();
        $status = $container->get('app.service.upload')->uploadVendors();
        
        $output->writeln('<fg=magenta>'.json_encode($status).'</fg=magenta>');
    }

}