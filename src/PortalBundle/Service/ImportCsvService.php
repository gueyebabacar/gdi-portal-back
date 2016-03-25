<?php

namespace PortalBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Repository\AgencyRepository;
use PortalBundle\Repository\RegionRepository;

/**
 * @DI\Service("service.csv_import", public=true)
 */
class ImportCsvService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\HttpKernel\KernelInterface
     */
    protected $kernel;

    /**
     * @var RegionRepository
     */
    protected $regionRepo;

    /**
     * @var AgencyRepository
     */
    protected $agencyRepo;

    /**
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "kernel" = @DI\Inject("kernel")
     *
     * })
     * @param $em
     * @param  $kernel
     */
    public function __construct($em, $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        $path = realpath($this->kernel->getRootDir() . "/../app/Resources/csv");

        return $path;
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvRegions($filePath = null)
    {
        $regionRepo = $this->em->getRepository('PortalBundle:Region');
        foreach ($regionRepo->findAll() as $item) {
            $this->em->remove($item);
        }
        $this->em->flush();
        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath() . "/" . "PERF_Region.v3.csv"; // Name of your CSV file
        }

        $header = true;
        try {
            if (($handle = fopen($csv_file, "r")) !== false) {
                $counterLine = 0;
                while (($fields = fgetcsv($handle, 1000, ",")) !== false) {
                    if ($header) {
                        $header = false;
                        continue;
                    }
                    if (strlen(implode($fields)) != 0) {
                        $region = new Region();
                        $region->setCode($fields[0]);
                        $region->setLabel($fields[1]);

                        $this->em->persist($region);
                        $this->em->flush();
                        $counterLine++;
                    }
                }
                echo $counterLine . "lines were succesfully added\n";
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvAgences($filePath = null)
    {
        $agencyRepo = $this->em->getRepository('PortalBundle:Agency');
        $regionRepo = $this->em->getRepository('PortalBundle:Region');
        foreach ($agencyRepo->findAll()  as $item) {
            $this->em->remove($item);
        }
        $this->em->flush();

        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath() . "/" . "PERF_Agence.v3.csv"; // Name of your CSV file
        }
        $header = true;
        try {
            if (($handle = fopen($csv_file, "r")) !== false) {
                $counterLine = 0;
                while (($fields = fgetcsv($handle, 1000, ",")) !== false) {

                    if ($header) {
                        $header = false;
                        continue;
                    }
                    if (strlen(implode($fields)) != 0) {
                        $agency = new Agency();
                        $agency->setRegion($regionRepo->findOneBy(['code' => $fields[0]]));
                        $agency->setCode($fields[1]);
                        $agency->setLabel($fields[2]);

                        $this->em->persist($agency);
                        $counterLine++;
                    }
                }
                $this->em->flush();
                echo $counterLine . "lines were succesfully added\n";
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}