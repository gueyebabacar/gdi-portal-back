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
            ->setName('portal:import')
            ->setDescription('Import des données de Portail GDI')
            ->setDefinition(array(
                new InputArgument('type', InputArgument::REQUIRED, "['user','regions','agencies']"),
                new InputArgument('filepath', InputArgument::OPTIONAL, 'Chemin vers le fichier de données'),
            ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ImportCsvService $importCsvService */
        $importCsvService = $this->getContainer()->get('service.csv_import');
        $filepath = $input->getArgument('filepath');
        $type = $input->getArgument('type');

        if ($filepath !== null && !is_file($filepath)) {
            throw new \Exception("File not found : '" . $filepath . "'!");
        }

        $output->writeln('Start');
        $output->writeln("Importing '" . $type . "' ...");

        switch ($type) {
            case 'users':
                $importCsvService->importCsvUsers($filepath);
                break;
            case 'regions':
                $importCsvService->importCsvRegions($filepath);
                break;
            case 'agencies':
                $importCsvService->importCsvAgencies($filepath);
                break;
            default :
                throw new \Exception("Unknown import type '" . $type . "'!");
        }
        $output->writeln('End');
    }
}