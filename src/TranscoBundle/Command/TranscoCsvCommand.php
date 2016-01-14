<?php

namespace TranscoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranscoCsvCommand extends ContainerAwareCommand
{

    const TranscoDestTerrSitre = "destinataire_site";
    const TranscoNatureInter = "nature_inter";
    const TranscoNatureOp = "nature_op";
    protected function configure()
    {
        $this
            ->setName('transco:import_csv')
            ->setDescription('This will export csv file content on database')
            ->addArgument(
                'option',
                InputArgument::OPTIONAL,
                'To export csv file choice on of these options
                    - destinataire_site : to export TranscoDestTerrSite table
                    - nature_inter: to export TranscoNatureIntervention table
                    - nature_op: to export TranscoNatureOperation table'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tableOption = $input->getArgument('option');
        switch ($tableOption) {

            case $this::TranscoDestTerrSitre:
                $exportCsv = $this->getContainer()->get('csv_import_service');
                $exportCsv->exportTranscoDestTerrSiteCvs();
                echo 'Exported csv file on TransDestTerrSite table done.....';
                break;

            case $this::TranscoNatureInter:
                $exportCsv = $this->getContainer()->get('csv_import_service');
                $exportCsv->exportTranscoNatureInterCvs();
                echo 'Exported csv file on TransNatureIntervention table done.....';
                break;

            case $this::TranscoNatureOp:
                $exportCsv = $this->getContainer()->get('csv_import_service');
                $exportCsv->exportTranscoNatureOp();
                echo 'Exported csv file on TransNatureOperation table done.....';
                break;

            default:
                echo 'You tell me one option';
                break;
        }


    }
}