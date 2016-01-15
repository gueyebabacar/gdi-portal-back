<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;

/**
 * AgenceDestinataireCenterPr
 *
 * @ORM\Table(name="agence_dest_center_pr")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\AgenceDestinataireCenterPrRepository")
 */
class AgenceDestinataireCenterPr
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * Type de travail
     *
     * @var $workType
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $nni;

    /**
     * code agence
     *
     * @var $gammeGroup
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $codeAgence;

    /**
     * Libelle agence
     *
     * @var $agenceLabel
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     */
    protected $agenceLabel;

    /**
     * center
     *
     * @var $center
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $center;

    /**
     * destinataire
     *
     * @var $destinataire
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $destinataire;

    /**
     * Pr
     *
     * @var $pr
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $pr;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AgenceDestinataireCenterPr
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNni()
    {
        return $this->nni;
    }

    /**
     * @param mixed $nni
     * @return AgenceDestinataireCenterPr
     */
    public function setNni($nni)
    {
        $this->nni = $nni;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeAgence()
    {
        return $this->codeAgence;
    }

    /**
     * @param mixed $codeAgence
     * @return AgenceDestinataireCenterPr
     */
    public function setCodeAgence($codeAgence)
    {
        $this->codeAgence = $codeAgence;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * @param mixed $center
     * @return AgenceDestinataireCenterPr
     */
    public function setCenter($center)
    {
        $this->center = $center;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgenceLabel()
    {
        return $this->agenceLabel;
    }

    /**
     * @param mixed $agenceLabel
     * @return AgenceDestinataireCenterPr
     */
    public function setAgenceLabel($agenceLabel)
    {
        $this->agenceLabel = $agenceLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestinataire()
    {
        return $this->destinataire;
    }

    /**
     * @param mixed $destinataire
     * @return AgenceDestinataireCenterPr
     */
    public function setDestinataire($destinataire)
    {
        $this->destinataire = $destinataire;
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
     * @return AgenceDestinataireCenterPr
     */
    public function setPr($pr)
    {
        $this->pr = $pr;
        return $this;
    }

}

