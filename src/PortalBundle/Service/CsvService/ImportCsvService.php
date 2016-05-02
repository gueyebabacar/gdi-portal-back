<?php

namespace PortalBundle\Service\CsvService;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;
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
     * @var Logger
     */
    public $logger;

    /**
     * @DI\InjectParams({
     *     "regionRepo" = @DI\Inject("portal.region_repository"),
     *     "agencyRepo" = @DI\Inject("portal.agency_repository"),
     *     "userRepo" = @DI\Inject("portal.user_repository"),
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "kernel" = @DI\Inject("kernel"),
     *     "logger" = @DI\Inject("monolog.logger.import")
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
        Kernel $kernel,
        Logger $logger
    ) {
        $this->agencyRepo = $agencyRepo;
        $this->regionRepo = $regionRepo;
        $this->userRepo = $userRepo;
        $this->kernel = $kernel;
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * Transform a CSV file into an array, keeping his references/titles
     *
     * @param string $fileName
     * @param null $header
     * @param string $delimiter
     * @return array
     */
    public function csvToArray($fileName, $header = null, $delimiter = ',')
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
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->em->getConnection()->beginTransaction();

        $header = ['CodeRegion', 'LibelleRegion'];
        $regionData = [];

        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath("PortailRegion.csv"); // Name of your CSV file
        }
        $this->logger->info('----------- Import du fichier "' . $csv_file . '" ... -----------');

        $counter = 0;
        $counterSuccess = 0;
        $regionArray = $this->csvToArray($csv_file, $header);

        foreach ($regionArray as $reg) {
            $counter++;
            $region = $this->regionRepo->findOneBy(['code' => $reg['CodeRegion']]);
            if (is_null($region)) {
                $region = new Region();
            }
            if (in_array($reg['CodeRegion'], $regionData)) {
                $this->importException('Erreur type "D" : Une ligne avec le Code Region \'' . $reg['CodeRegion'] . '\' a déja été inserée (ligne ' . ($counter + 1) . ')');
                continue;
            } else {
                $region->setCode($reg['CodeRegion']);
                $region->setLabel($reg['LibelleRegion']);
                $this->em->persist($region);
                $regionData[] = $reg['CodeRegion'];
                $counterSuccess++;
            }
        }

        try {
            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->em->clear();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            $this->importException($e->getMessage() . ' - opération annulée');
            $counterSuccess = 0;
            echo $e->getMessage();
        }
        $report = '----------- Import Terminé. Total : ' . $counter . '. Inserés : ' . $counterSuccess . '. Erreurs : ' . ($counter - $counterSuccess) . ' -----------';
        echo $report . "\n";
        $this->logger->info($report);
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvAgencies($filePath = null)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->em->getConnection()->beginTransaction();

        $header = ['CodeRegion', 'CodeAgence', 'LibelleAgence', 'code_gestion_agence'];

        $agencyData = [];

        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath("PortailAgence.csv"); // Name of your CSV file
        }

        $counter = 0;
        $counterSuccess = 0;
        $agencyArray = $this->csvToArray($csv_file, $header);

        foreach ($agencyArray as $age) {
            $counter++;
            $region = $this->regionRepo->findOneBy(['code' => $age['CodeRegion']]);
            $agency = $this->agencyRepo->findOneBy(['code' => $age['CodeAgence']]);
            if (is_null($region)) {
                $this->importException('Erreur type "I" : La région \'' . $age['CodeRegion'] . '\' est introuvable (ligne ' . ($counter + 1) . ')');
            } else {
                if (is_null($agency)) {
                    $agency = new Agency();
                }
                if (in_array($age['CodeAgence'], $agencyData)) {
                    $this->importException('Erreur type "D" : Une ligne avec le Code Agence \'' . $age['CodeAgence'] . '\' a déja été inserée (ligne ' . ($counter + 1) . ')');
                    continue;
                } else {
                    $agency->setCode($age['CodeAgence']);
                    $agency->setLabel($age['LibelleAgence']);
                    $agency->setRegion($region);
                    $this->em->persist($agency);
                    $agencyData[] = $age['CodeAgence'];
                    $counterSuccess++;
                }
            }
        }

        try {
            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->em->clear();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            $this->importException($e->getMessage() . ' - opération annulée');
            $counterSuccess = 0;
            echo $e->getMessage();
        }
        $report = '----------- Import Terminé. Total : ' . $counter . '. Inserés : ' . $counterSuccess . '. Erreurs : ' . ($counter - $counterSuccess) . ' -----------';
        echo $report . "\n";
        $this->logger->info($report);
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvUsers($filePath = null)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->em->getConnection()->beginTransaction();

        $header = ['PRENOM', 'NOM', 'GAIA', 'ROLE', 'NNI', 'TEL1', 'TEL2', 'EMAIL', 'ENTITE', 'REGION', 'AGENCE'];

        $userData['gaias'] = [];
        $userData['nnis'] = [];
        $userData['emails'] = [];

        if ($filePath !== null) {
            $csv_file = $filePath;
        } else {
            $csv_file = $this->getPath("PortailUtilisateur.csv"); // Name of your CSV file
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

            if (!is_null($userByGaia)) {
                $this->importException('Erreur type "D" : Un utilisateur avec le GAIA \'' . $use['GAIA'] . '\' existe déjà (ligne ' . ($counter + 1) . ')');
            }
            if (empty($use['GAIA'])) {
                $this->importException('Erreur type "I" : L\'utilisateur \'' . $use['PRENOM'] . ' ' . $use['NOM'] . '\' n\'est associé à aucun GAIA (ligne ' . ($counter + 1) . ')');
            } elseif (in_array($use['GAIA'], $userData['gaias'])) {
                $this->importException('Erreur type "D" : Un utilisateur avec le GAIA \'' . $use['GAIA'] . '\' a déjà été inseré (ligne ' . ($counter + 1) . ')');
            } elseif (!is_null($userByEmail)) {
                $this->importException('Erreur type "D" : Un utilisateur avec le mail \'' . $use['EMAIL'] . '\' existe déjà (ligne ' . ($counter + 1) . ')');
            } elseif (!empty($use['EMAIL']) && in_array($use['EMAIL'], $userData['emails'])) {
                $this->importException('Erreur type "D" : Un utilisateur avec le mail \'' . $use['EMAIL'] . '\' a déjà été inseré (ligne ' . ($counter + 1) . ')');
            } elseif (!is_null($userByNni)) {
                $this->importException('Erreur type "D" : Un utilisateur avec le NNI \'' . $use['NNI'] . '\' existe déjà (ligne ' . ($counter + 1) . ')');
            } elseif (!empty($use['NNI']) && in_array($use['NNI'], $userData['nnis'])) {
                $this->importException('Erreur type "D" : Un utilisateur avec le NNI \'' . $use['NNI'] . '\' a déjà été inseré (ligne ' . ($counter + 1) . ')');
            } elseif (!empty($use['AGENCE']) && is_null($agency)) {
                $this->importException('Erreur type "I" : L\'agence \'' . $use['AGENCE'] . '\' est introuvable (ligne ' . ($counter + 1) . ')');
            } elseif (!empty($use['REGION']) && is_null($region)) {
                $this->importException('Erreur type "I" : La region \'' . $use['REGION'] . '\' est introuvable (ligne ' . ($counter + 1) . ')');
            } else {
                $user = new User();
                if ($userByGaia === null && $userByEmail === null && $userByNni === null || empty($use['AGENCE'])) {
                    $user->setFirstName($use['PRENOM']);
                    $user->setLastName($use['NOM']);
                    $user->setUsername($use['GAIA']);
                    $user->addRole($use['ROLE']);
                    $use['NNI'] === '' ? $user->setNni(null) : $user->setNni($use['NNI']);
                    $use['TEL1'] === '' ? $user->setPhone1(null) : $user->setPhone1($use['TEL1']);
                    $use['TEL2'] === '' ? $user->setPhone2(null) : $user->setPhone2($use['TEL2']);
                    $use['EMAIL'] === '' ? $user->setEmail(null) : $user->setEmail($use['EMAIL']);
                    $use['ENTITE'] === '' ? $user->setEntity(null) : $user->setEntity($use['ENTITE']);
                    $user->setAgency($agency);
                    $user->setRegion($region);
                    $user->setEnabled(true);
                    $this->em->persist($user);

                    if ($use['EMAIL'] !== '') {
                        $userData['emails'][] = $use['EMAIL'];
                    }
                    if ($use['NNI'] !== '') {
                        $userData['nnis'][] = $use['NNI'];
                    }
                    $userData['gaias'][] = $use['GAIA'];

                    $counterSuccess++;
                }
            }
        }
        try {
            $this->em->flush();
            $this->em->getConnection()->commit();
            $this->em->clear();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            $this->importException($e->getMessage() . ' - opération annulée');
            $counterSuccess = 0;
            echo $e->getMessage();
        }
        $report = '----------- Import Terminé. Total : ' . $counter . '. Inserés : ' . $counterSuccess . '. Erreurs : ' . ($counter - $counterSuccess) . ' -----------';
        echo $report . "\n";
        $this->logger->info($report);
    }

    /**
     * Logs import Exceptions
     * @param $message
     */
    private function importException($message)
    {
        $this->logger->error($message);
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