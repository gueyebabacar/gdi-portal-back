<?php

namespace PortalBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('csv:import-portal')
            ->setDescription('This will import csv file content into database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importCsvService = $this->getContainer()->get('service.csv_import');
        try {
            $importCsvService->importCsvRegions();
            $importCsvService->importCsvAgences();
        }catch (Exception $e){
            echo $e->getMessage();
        }
        echo "CSV files successfully imported\n";
    }
}