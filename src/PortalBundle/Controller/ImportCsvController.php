<?php
namespace PortalBundle\Controller;

use PortalBundle\Entity\TranscoDestTerrSite;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\EventDispatcher\Tests\Debug\TraceableEventDispatcherTest;
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

        $dumpCsv = $this->get('csv_import_service');
        $dumpCsv->dumpCvs();

        return new Response('TranscodestTerrSite csv file uploaded on database succesfully');

    }

}

