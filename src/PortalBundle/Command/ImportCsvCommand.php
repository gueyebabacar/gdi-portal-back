<?php

namespace PortalBundle\Command;

use PortalBundle\Service\CsvService\ImportCsvService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('This will import csv file content into database')
            ->setDefinition(array(
                new InputArgument('type', InputArgument::REQUIRED, "['user','region','agence']"),
                new InputArgument('filepath', InputArgument::OPTIONAL, 'The path of the csv file'),
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ImportCsvService $importCsvService */
        $importCsvService = $this->getContainer()->get('service.csv_import');
        $filepath = $input->getArgument('filepath');
        $entityName = $input->getArgument('entity');

        if ($filepath !== null && !is_file($filepath)) {
            throw new \Exception("File not found : '" . $filepath . "'!");
        }

        $output->writeln('Start');
        $output->writeln("Importing '" . $entityName . "' ...");

        switch ($entityName) {
            case 'users':
                $importCsvService->importCsvUsers($filepath);
                break;
            case 'regions':
                $importCsvService->importCsvRegions($filepath);
                break;
            case 'agencies':
                $importCsvService->importCsvAgencies($filepath);
                break;
        }
        $output->writeln('End');
    }
}