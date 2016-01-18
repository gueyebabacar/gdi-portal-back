<?php

namespace TranscoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranscoImportCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('transco:import')
            ->setDescription('This will export csv file content on database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exportCsv = $this->getContainer()->get('service.csv_import');
        $exportCsv->importCsvTranscoTables();
        echo "CSV file successfully imported\n";
    }
}