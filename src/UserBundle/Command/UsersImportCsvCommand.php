<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UsersImportCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('csv:import:users')
            ->setDescription('This will export csv file content on database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importUsers = $this->getContainer()->get('service.csv_import_users');
            $importUsers->importCsvUsers();
        try {
        }catch (Exception $e){
            echo $e->getMessage();
        }
        echo "CSV files successfully imported\n";
    }
}