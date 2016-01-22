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
     * @param $filePath
     */
    public function importCsvTranscoTables($filePath)
    {
        $this->emptyTables();
        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath() . "/" . "transcos.csv"; // Name of your CSV file
        }

        $header = true;
        try {
            if (($handle = fopen($csv_file, "r")) !== false) {
                $counterLine = 0;
                while (($fields = fgetcsv($handle, 1000, ";")) !== false) {
                    if ($header) {
                        $header = false;
                        continue;
                    }
                    if (strlen(implode($fields)) != 0) {
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
                        $transcoOptic->setSla($fields[14]);
                        $transcoOptic->setSlot($fields[15]);
                        $transcoOptic->setDisco($transcoDisco);

                        $gmaoCounters = $fields[18];

                        if ($fields[16] != null && $fields[17] != null && $fields[18] != null) {
                            foreach (explode(',', $gmaoCounters) as $counter) {
                                $transcoGmao = new TranscoGmao();
                                $transcoGmao->setWorkType($fields[16]);
                                $transcoGmao->setGroupGame($fields[17]);
                                $transcoGmao->setCounter(trim($counter));
                                $transcoGmao->setOptic($transcoOptic);
                                $transcoOptic->addGmao($transcoGmao);
                                $this->em->persist($transcoGmao);
                            }
                        }

                        $transcoDisco->setOptic($transcoOptic);
                        $this->em->persist($transcoOptic);
                        $this->em->persist($transcoDisco);
                        $this->em->flush();
                        $counterLine++;
                        echo "Line " . $counterLine . " succesfully added\n";
                    }
                }
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * emptyTables
     */
    public function emptyTables()
    {
        foreach ($this->em->getRepository('TranscoBundle:TranscoOptic')->findAll() as $item) {
            $this->em->remove($item);
            $this->em->flush();
        }
    }
}