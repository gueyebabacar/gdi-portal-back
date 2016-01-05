<?php
namespace PortalBundle\Controller;

use PortalBundle\Entity\TranscoDestTerrSite;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * Transco Import CSV filz
 */
class ImportCsvController extends FOSRestController
{

    /**
     * Import a csv file in transcodestinatairesite table.
     * @Rest\Get("/import/csv")
     * @Rest\View
     *
     * )
     */
    public function destiTerrsiteImportCsvAction()
    {

        $path = realpath($this->get('kernel')->getRootDir() . "/../doc/");
        define('CSV_PATH',$path);

        $csv_file = CSV_PATH . "test.csv"; // Name of your CSV file
        $csvfile = fopen($csv_file, 'r');
        $transcoDestTerrSite = new  TranscoDestTerrSite();
        $i = 0;
        while (!feof($csvfile)) {
            $csv_data[] = fgets($csvfile, 1024);
            $csv_array = explode(",", $csv_data[$i]);

            $transcoDestTerrSite->setIdRefStructureOp($csv_array[3]);
            $transcoDestTerrSite->setTerritory($csv_array[0]);
            $transcoDestTerrSite->setAdressee($csv_array[1]);
            $transcoDestTerrSite->setSite($csv_array[2]);
            $transcoDestTerrSite->setPr($csv_array[4]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($transcoDestTerrSite);
            $i++;
        }

        fclose($csvfile);

        return new Response("File data successfully imported to database!!");

    }
}