<?php

namespace PortalBundle\Service\CsvService;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Entity\TranscoDestTerrSite;
use Symfony\Component\DependencyInjection\Container;

/**
 * @DI\Service("csv_import_service", public=true)
 */
class TranscoDestTerrSiteCsvService
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
     * parse a csv file and store it on db
     */
    public function dumpCvs()
    {
        $path = realpath($this->container->get('kernel')->getRootDir() . "/../web/");
//        $path = realpath($this->container->get('kernel')->getRootDir());

        var_dump($path); exit;
        define('CSV_PATH', $path);
        $csv_file = CSV_PATH . "/" . "TranscoDestTerrSite.csv"; // Name of your CSV file

        $fil_content = file($csv_file);

        for($i = 1; $i<count($fil_content); $i++) {

            $transcoDestTerrSite = new TranscoDestTerrSite();
            $transcoDesTerrSite = explode(";", $fil_content[$i]);
            $transcoDestTerrSite->setTerritory($transcoDesTerrSite[0]);
            $transcoDestTerrSite->setAdressee($transcoDesTerrSite[1]);
            $transcoDestTerrSite->setSite($transcoDesTerrSite[2]);
            $transcoDestTerrSite->setIdRefStructureOp($transcoDesTerrSite[3]);
            $transcoDestTerrSite->setPr($transcoDesTerrSite[4]);

            $this->em->persist($transcoDestTerrSite);
            $this->em->flush();
        }
    }
}