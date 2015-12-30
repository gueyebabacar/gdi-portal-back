<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoDestTerrSite
 *
 * @ORM\Table(name="transco_dest_terr_site")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\TranscoDestTerrSiteRepository")
 */
class TranscoDestTerrSite
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * territoire
     *
     * @var $territory
     * @ORM\Column(type="integer")
     */
    protected $territory;

    /**
     * destinataire
     *
     * @var $adressee
     * @ORM\Column(type="string")
     */
    protected $adressee;

    /**
     * site
     *
     * @var $site
     * @ORM\Column(type="string")
     */
    protected $site;

    /**
     * pr
     *
     * @var $pr
     * @ORM\Column(type="string")
     */
    protected $pr;

    /**
     * identifiant reference structure operationnelle
     *
     * @var $idRefStructureOp
     * @ORM\Column(type="string")
     */
    protected $idRefStructureOp;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTerritory()
    {
        return $this->territory;
    }

    /**
     * @param mixed $territory
     */
    public function setTerritory($territory)
    {
        $this->territory = $territory;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdressee()
    {
        return $this->adressee;
    }

    /**
     * @param mixed $adressee
     */
    public function setAdressee($adressee)
    {
        $this->adressee = $adressee;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPr()
    {
        return $this->pr;
    }

    /**
     * @param mixed $pr
     */
    public function setPr($pr)
    {
        $this->pr = $pr;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdRefStructureOp()
    {
        return $this->idRefStructureOp;
    }

    /**
     * @param mixed $idRefStructureOp
     */
    public function setIdRefStructureOp($idRefStructureOp)
    {
        $this->idRefStructureOp = $idRefStructureOp;
        return $this;
    }

}

