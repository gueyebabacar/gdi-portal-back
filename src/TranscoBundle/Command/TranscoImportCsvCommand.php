<?php

namespace TranscoBundle\Command;

use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranscoImportCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('transco:import')
            ->setDescription('Import Transco tables data from csv file');
        $this->addArgument('path',
            InputArgument::OPTIONAL,
            'Specify the path of CSV file');;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exportCsv = $this->getContainer()->get('service.csv_import');
        $exportCsv->importCsvTranscoTables($input->getArgument('path'));
        echo "CSV file successfully imported\n";
    }
}