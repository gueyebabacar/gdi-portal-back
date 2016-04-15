<?php

namespace PortalBundle\Service\CsvService;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Repository\AgencyRepository;
use PortalBundle\Repository\RegionRepository;
use Symfony\Component\HttpKernel\Kernel;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;

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
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @DI\InjectParams({
     *     "regionRepo" = @DI\Inject("portal.region_repository"),
     *     "agencyRepo" = @DI\Inject("portal.agency_repository"),
     *     "userRepo" = @DI\Inject("portal.user_repository"),
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "kernel" = @DI\Inject("kernel"),
     *
     * })
     * @param RegionRepository $regionRepo
     * @param AgencyRepository $agencyRepo
     * @param UserRepository $userRepo
     * @param $em
     * @param $kernel
     */
    public function __construct(
        RegionRepository $regionRepo,
        AgencyRepository $agencyRepo,
        UserRepository $userRepo,
        EntityManager $em,
        Kernel $kernel
    ) {
        $this->agencyRepo = $agencyRepo;
        $this->regionRepo = $regionRepo;
        $this->userRepo= $userRepo;
        $this->kernel = $kernel;
        $this->em = $em;
    }

    /**
     * Transform a CSV file into an array, keeping his references/titles
     *
     * @param string $fileName
     * @param null $header
     * @param string $delimiter
     * @return array
     */
    public function csvToArray($fileName, $header = null, $delimiter = ';')
    {
        if (!file_exists($fileName) || !is_readable($fileName)) {
            return false;
        }

        $isHeader = true;
        $data = array();
        $count = 0;
        if (($handle = fopen($fileName, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if ($isHeader) {
                    $header = ($header) ? ($header) : ($row);
                    $isHeader = false;
                } else {

                    try {
                       $data[] = array_combine($header, $row);
                        $count++;
                    } catch (\Exception $e) {
                        dump($header, $row);
                       exit();
                    }
                }
            }
            fclose($handle);
        }

        return $data;
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvRegions($filePath = null)
    {
        $header = ['CodeRegion', 'LibelleRegion'];

        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath("Portail_Region.v3.csv"); // Name of your CSV file
        }

        $counter = 0;
        $counterSuccess = 0;
        $regionArray = $this->csvToArray($csv_file, $header);
        foreach ($regionArray as $reg) {
            $counter++;
            $region = $this->regionRepo->findOneBy(['code' => $reg['CodeRegion']]);
            if (is_null($region)) {
                $region = new Region();
            }
            $region->setCode($reg['CodeRegion']);
            $region->setLabel($reg['LibelleRegion']);
            $this->em->persist($region);
            try {
                $this->em->flush();
                $counterSuccess++;
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

        }
        echo "$counterSuccess/$counter regions added successfully\n";
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvAgencies($filePath = null)
    {
        $header = ['CodeRegion', 'CodeAgence', 'LibelleAgence', 'code_gestion_agence'];
        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath("Portail_Agence.v3.csv"); // Name of your CSV file
        }

        $counter = 0;
        $counterSuccess = 0;
        $agencyArray = $this->csvToArray($csv_file, $header);
        foreach ($agencyArray as $age) {
            $counter++;
            $region = $this->regionRepo->findOneBy(['code' => $age['CodeRegion']]);
            $agency = $this->agencyRepo->findOneBy(['code' => $age['CodeAgence']]);
            if (is_null($region)) {
                echo "The line $counter was not inserted because the region code " . $age['CodeRegion'] . " doesn't exists \n";
            } else {
                if (is_null($agency)){
                    $agency = new Agency();
                }
                $agency->setCode($age['CodeAgence']);
                $agency->setLabel($age['LibelleAgence']);
                $agency->setRegion($region);
                $this->em->persist($agency);
                try {
                    $this->em->flush();
                    $counterSuccess++;
                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        echo "$counterSuccess/$counter agencies added successfully\n";
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvUsers($filePath = null)
    {
        $header = ['PRENOM', 'NOM', 'GAIA', 'ROLE', 'NNI', 'TEL1', 'TEL2', 'EMAIL', 'ENTITE', 'REGION', 'AGENCE'];

        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath("Portail_utilisateurs.csv"); // Name of your CSV file
        }

        $counter = 0;
        $counterSuccess = 0;
        $userByGaia = null;
        $userByNni = null;
        $userByEmail = null;
        $userArray = $this->csvToArray($csv_file, $header);
        foreach ($userArray as $use) {
            $counter++;
            $agency = $this->agencyRepo->findOneBy(['code' => $use['AGENCE']]);
            $region = $this->regionRepo->findOneBy(['code' => $use['REGION']]);
            $userByGaia = $this->userRepo->findOneBy(['username' => $use['GAIA']]);
            if (!empty($use['EMAIL'])) {
                $userByEmail = $this->userRepo->findOneBy(['email' => $use['EMAIL']]);
            }
            if (!empty($use['NNI'])) {
                $userByNni = $this->userRepo->findOneBy(['nni' => $use['NNI']]);
            }

            if (!empty($userByGaia)) {
                echo "The line $counter " . $use['NOM'] . " " . $use['PRENOM'] . " was not inserted because the GAIA " . $use['GAIA'] . " already exists \n";
            } elseif (!empty($userByEmail)) {
                    echo "The line $counter " . $use['NOM'] . " " . $use['PRENOM'] . " was not inserted because the email " . $use['EMAIL'] . " already exists \n";
            } elseif (!empty($userByNni)) {
                    echo "The line $counter " . $use['NOM'] . " " . $use['PRENOM'] . " was not inserted because the NNI " . $use['NNI'] . " already exists \n";
            } else {
                $user = new User();
                if ($userByGaia === null && $userByEmail === null && $userByNni === null) {
                    $user->setFirstName($use['PRENOM']);
                    $user->setLastName($use['NOM']);
                    $user->setUsername($use['GAIA']);
                    $user->addRole($use['ROLE']);
                    $use['NNI'] === '' ? $user->setNni(null) : $user->setNni($use['NNI']);
                    $user->setPhone1($use['TEL1']);
                    $user->setPhone2($use['TEL2']);
                    $use['EMAIL'] === '' ? $user->setEmail(null) : $user->setEmail($use['EMAIL']);
                    $use['ENTITE'] === '' ? $user->setEntity(null) : $user->setEntity($use['ENTITE']);
                    $user->setAgency($agency);
                    $user->setRegion($region);
                    $user->setEnabled(true);
                    $this->em->persist($user);
                    try {
                        $this->em->flush();
                        $counterSuccess++;
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }
        echo "$counterSuccess/$counter users added successfully\n";
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getPath($fileName)
    {
        $path = realpath($this->kernel->getRootDir() . "/../web/uploads/csv");

        return $path . "/" . $fileName;
    }
}