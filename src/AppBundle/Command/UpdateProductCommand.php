<?php
/**
 * Command used for Users section to upload csv file.
 *
 * @author Saswati
 *
 * @category Custom Command
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateProductCommand extends ContainerAwareCommand
{
    /**
     * Function to set the name, description and argument for the upload:csv-file command.
     */
    protected function configure()
    {
        $this
            ->setName('upload:products')
            ->setDescription('create new products in users table')
        ;
    }
    /**
     * Function to execute the upload:products command to upload to .
     *
     *@param InputInterface $input
     *@param OutputInterface $output
     *
     *@return 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $container = $this->getContainer();
        $status = $container->get('app.service.upload')->uploadProducts();
       
        $output->writeln('<fg=magenta>'.json_encode($status).'</fg=magenta>');
    }

}