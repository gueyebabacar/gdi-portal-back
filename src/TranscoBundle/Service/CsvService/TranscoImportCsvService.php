<?php

namespace TranscoBundle\Service\CsvService;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\DependencyInjection\Container;
use TranscoBundle\Entity\TranscoDisco;
use TranscoBundle\Entity\TranscoGmao;
use TranscoBundle\Entity\TranscoOptic;

/**
 * @DI\Service("service.csv_import", public=true)
 */
class TranscoImportCsvService
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
    public function getPath()
    {
        $path = realpath($this->container->get('kernel')->getRootDir() . "/../web/uploads/csv");

        return $path;
    }

    /**
     * parse a csv file and store it on db
     */
    public function importCsvTranscoTables()
    {
        $this->em->createQuery('DELETE FROM  TranscoBundle:TranscoGmao')->execute();
        $this->em->createQuery('DELETE FROM  TranscoBundle:TranscoDisco')->execute();
        $this->em->createQuery('DELETE FROM  TranscoBundle:TranscoOptic')->execute();
        $csv_file = $this->getPath() . "/" . "transcos.csv"; // Name of your CSV file
        $header = true;

        if (($handle = fopen($csv_file, "r")) !== false) {
            while (($fields = fgetcsv($handle, 1000, ";")) !== false) {
                if ($header) {
                    $header = false;
                    continue;
                }
                $transcoDisco = new TranscoDisco();
                $transcoDisco->setCodeObject($fields[0]);
                $transcoDisco->setNatOp($fields[1]);
                $transcoDisco->setNatOpLabel($fields[2]);

                $transcoOptic = new TranscoOptic();
                $transcoOptic->setCodeTypeOptic($fields[3]);
                $transcoOptic->setOpticLabel($fields[4]);
                $transcoOptic->setCodeNatInter($fields[5]);
                $transcoOptic->setLabelNatInter($fields[6]);
                $transcoOptic->setSegmentationCode($fields[7]);
                $transcoOptic->setSegmentationLabel($fields[8]);
                $transcoOptic->setFinalCode($fields[9]);
                $transcoOptic->setFinalLabel($fields[10]);
                $transcoOptic->setShortLabel($fields[11]);
                $transcoOptic->setProgrammingMode($fields[12]);
                $transcoOptic->setCalibre($fields[13]);
                $transcoOptic->setDisco($transcoDisco);

                $gmaoCounters = $fields[16];

                if ($fields[14] != null && $fields[15] != null && $fields[16] != null) {
                    foreach (explode(',', $gmaoCounters) as $counter) {
                        $transcoGmao = new TranscoGmao();
                        $transcoGmao->setWorkType($fields[14]);
                        $transcoGmao->setGroupGame($fields[15]);
                        $transcoGmao->setCounter(trim($counter));
                        $transcoOptic->addGmao($transcoGmao);
                        $this->em->persist($transcoGmao);
                    }
                }

                $transcoDisco->setOptic($transcoOptic);
                $this->em->persist($transcoOptic);
                $this->em->persist($transcoDisco);
                $this->em->flush();
            }
        }
    }
}