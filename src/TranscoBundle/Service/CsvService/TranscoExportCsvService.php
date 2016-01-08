<?php

namespace TranscoBundle\Service\CsvService;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use TranscoBundle\Entity\TranscoDestTerrSite;
use Symfony\Component\DependencyInjection\Container;
use TranscoBundle\Entity\TranscoNatureInter;
use TranscoBundle\Entity\TranscoNatureOpe;

/**
 * @DI\Service("csv_import_service", public=true)
 */
class TranscoExportCsvService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "container" = @DI\Inject("service_container")
     * })
     * @param $em
     * @param $container
     */
    public function __construct($em, $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @return string
     */
    private function getPath()
    {
        $path = realpath($this->container->get('kernel')->getRootDir() . "/../web/uploads/csv");

        return $path;
    }

    /**
     * parse a csv file and store it on db
     */
    public function exportTranscoDestTerrSiteCvs()
    {
        $csv_file = $this->getPath(). "/" . "TranscoDestTerrSite.csv"; // Name of your CSV file
        $fil_content = file($csv_file);

        for($i = 1; $i<count($fil_content); $i++) {

            $transcoDestTerrSite = new TranscoDestTerrSite();
            $transcoCvsValue = explode(";", $fil_content[$i]);
            $transcoDestTerrSite->setTerritory($transcoCvsValue[0]);
            $transcoDestTerrSite->setAdressee($transcoCvsValue[1]);
            $transcoDestTerrSite->setSite($transcoCvsValue[2]);
            $transcoDestTerrSite->setIdRefStructureOp($transcoCvsValue[3]);
            $transcoDestTerrSite->setPr($transcoCvsValue[4]);

            $this->em->persist($transcoDestTerrSite);
            $this->em->flush();
        }
    }

    /**
     * parse a csv file and store it on db
     */
    public function exportTranscoNatureInterCvs()
    {
        $csv_file = $this->getPath(). "/" . "TranscoNatureInter.csv"; // Name of your CSV file
        $fil_content = file($csv_file);

        for($i = 1; $i<count($fil_content); $i++) {

            $transcoNatureInter = new TranscoNatureInter();
            $transcoCvsValue = explode(";", $fil_content[$i]);
            $transcoNatureInter->setOpticNatCode($transcoCvsValue[0]);
            $transcoNatureInter->setOpticSkill($transcoCvsValue[1]);
            $transcoNatureInter->setOpticNatLabel($transcoCvsValue[2]);
            $transcoNatureInter->setPictrelNatOpCode($transcoCvsValue[3]);
            $transcoNatureInter->setPictrelNatOpLabel($transcoCvsValue[4]);
            $transcoNatureInter->setTroncatedPictrelNatOpLabel($transcoCvsValue[5]);
            $transcoNatureInter->setCounter($transcoCvsValue[6]);

            $this->em->persist($transcoNatureInter);
            $this->em->flush();
        }
    }

    /**
     * parse a csv file and store it on db
     */
    public function exportTranscoNatureOp()
    {
        $csv_file = $this->getPath(). "/" . "TranscoNatureOp.csv"; // Name of your CSV file
        $fil_content = file($csv_file);

        for($i = 1; $i<count($fil_content); $i++) {

            $transcoNatureOp = new TranscoNatureOpe();
            $transcoCvsValue = explode(";", $fil_content[$i]);
            $transcoNatureOp->setWorkType($transcoCvsValue[0]);
            $transcoNatureOp->setGammeGroup($transcoCvsValue[1]);
            $transcoNatureOp->setCounter($transcoCvsValue[2]);
            $transcoNatureOp->setPurpose($transcoCvsValue[3]);
            $transcoNatureOp->setNatureInterCode($transcoCvsValue[4]);
            $transcoNatureOp->setSegmentationName($transcoCvsValue[5]);
            $transcoNatureOp->setSegmentationValue($transcoCvsValue[6]);

            $this->em->persist($transcoNatureOp);
            $this->em->flush();
        }
    }
}