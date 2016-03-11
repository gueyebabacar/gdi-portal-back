<?php

namespace UserBundle\Service\CsvService;

use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation as DI;
use UserBundle\Entity\User;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;

/**
 * @DI\Service("service.csv_import_users", public=true)
 */
class UsersImportCsvService
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
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager"),
     *     "kernel" = @DI\Inject("kernel")
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
        $path = realpath($this->kernel->getRootDir() . "/../web/uploads/csv");

        return $path;
    }

    /**
     * parse a csv file and store it on db
     * @param $filePath
     */
    public function importCsvUsers($filePath = null)
    {
        if ($filePath !== null) {
            $csvFile = $filePath;
        } else {
            $csvFile = $this->getPath() . "/" . "users.csv"; // Name of your CSV file
        }

        $header = true;
        try {
            if (($handle = fopen($csvFile, "r")) !== false) {
                $counterLine = 0;
                while (($fields = fgetcsv($handle, 1000, ";")) !== false) {
                    if ($header) {
                        $header = false;
                        continue;
                    }

                    if (strlen(implode($fields)) != 0) {
                        $user = new User();
                        $agency = $this->em->getRepository('PortalBundle:Agency')->findOneByCode($fields[8]);
                        $region = $this->em->getRepository('PortalBundle:Region')->findOneByCode($fields[9]);
                        $userByGaia = $this->em->getRepository('UserBundle:User')->findOneByUsername($fields[2]);

                        if ($userByGaia === null) {
                            $user->setUsername($fields[2]);
                            $user->setFirstName($fields[0]);
                            $user->setLastName($fields[1]);
                            $user->setNni($fields[3]);
                            $user->setPhone1($fields[4]);
                            $user->setPhone2($fields[5]);
                            $user->setEmail($fields[6]);
                            $user->setEntity($fields[7]);
                            $user->setAgency($agency);
                            $user->setRegion($region);

                            $this->em->persist($user);
                            $counterLine++;
                        }
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