<?php
/**
 * Command used for Account section to upload csv file.
 *
 * @author Saswati
 *
 * @category Custom Command
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAccountCommand extends ContainerAwareCommand
{
    /**
     * Function to set the name, description and argument for the upload:accounts command.
     */
    protected function configure()
    {
        $this
            ->setName('upload:accounts')
            ->setDescription('create new accounts in users table')
        ;
    }
    /**
     * Function to execute the upload:accounts command to upload to .
     *
     *@param InputInterface $input
     *@param OutputInterface $output
     *
     *@return 
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {   
        $container = $this->getContainer();
        $status = $container->get('app.service.upload')->uploadAccount();
        
        $output->writeln('<fg=magenta>'.json_encode($status).'</fg=magenta>');
    }

}