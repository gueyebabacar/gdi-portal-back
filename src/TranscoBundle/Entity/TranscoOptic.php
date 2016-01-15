<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoDestTerrSite
 *
 * @ORM\Table(name="transco_optic")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoOpticRepository")
 */
class TranscoOptic
{
    const TYPE_DE_TRAVAIL = "TypeDeTravail";
    const GROUPE_DE_GAMME = "GroupeDeGamme";
    const COMPTEUR = "Compteur";

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * code type optic
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codeTypeOptic;

    /**
     * libellé optic
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $opticLabel;

    /**
     * code nature intervention
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codeNatInter;

    /**
     * code segmentation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $segmentationCode;

    /**
     * labelle segmentation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $segmentationLabel;

    /**
     * code finalite
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $finalCode;

    /**
     * labelle finalite
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $finalLabel;

    /**
     * libelle court
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shortLabel;

    /**
     * mode de programmation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $programmingMode;

    /**
     * calibre
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $calibre;

    /**
     * $gmao
     *
     * @var TranscoGmao
     * @ORM\OneToOne(targetEntity="TranscoGmao", mappedBy="optic")
     */
    protected $gmao;

    /**
     * $disco
     *
     * @var TranscoDisco
     * @ORM\OneToOne(targetEntity="TranscoDisco", mappedBy="optic")
     */
    protected $disco;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TranscoOptic
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeTypeOptic()
    {
        return $this->codeTypeOptic;
    }

    /**
     * @param mixed $codeTypeOptic
     * @return TranscoOptic
     */
    public function setCodeTypeOptic($codeTypeOptic)
    {
        $this->codeTypeOptic = $codeTypeOptic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpticLabel()
    {
        return $this->opticLabel;
    }

    /**
     * @param mixed $opticLabel
     * @return TranscoOptic
     */
    public function setOpticLabel($opticLabel)
    {
        $this->opticLabel = $opticLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeNatInter()
    {
        return $this->codeNatInter;
    }

    /**
     * @param mixed $codeNatInter
     * @return TranscoOptic
     */
    public function setCodeNatInter($codeNatInter)
    {
        $this->codeNatInter = $codeNatInter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmentationCode()
    {
        return $this->segmentationCode;
    }

    /**
     * @param mixed $segmentationCode
     * @return TranscoOptic
     */
    public function setSegmentationCode($segmentationCode)
    {
        $this->segmentationCode = $segmentationCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmentationLabel()
    {
        return $this->segmentationLabel;
    }

    /**
     * @param $segmentationLabel
     * @return TranscoOptic
     */
    public function setSegmentationLabel($segmentationLabel)
    {
        $this->segmentationLabel = $segmentationLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFinalCode()
    {
        return $this->finalCode;
    }

    /**
     * @param mixed $finalCode
     * @return TranscoOptic
     */
    public function setFinalCode($finalCode)
    {
        $this->finalCode = $finalCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFinalLabel()
    {
        return $this->finalLabel;
    }

    /**
     * @param mixed $finalLabel
     * @return TranscoOptic
     */
    public function setFinalLabel($finalLabel)
    {
        $this->finalLabel = $finalLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortLabel()
    {
        return $this->shortLabel;
    }

    /**
     * @param mixed $shortLabel
     * @return TranscoOptic
     */
    public function setShortLabel($shortLabel)
    {
        $this->shortLabel = $shortLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProgrammingMode()
    {
        return $this->programmingMode;
    }

    /**
     * @param mixed $programmingMode
     * @return TranscoOptic
     */
    public function setProgrammingMode($programmingMode)
    {
        $this->programmingMode = $programmingMode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCalibre()
    {
        return $this->calibre;
    }

    /**
     * @param mixed $calibre
     * @return TranscoOptic
     */
    public function setCalibre($calibre)
    {
        $this->calibre = $calibre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGmao()
    {
        return $this->gmao;
    }

    /**
     * @param mixed $gmao
     * @return TranscoOptic
     */
    public function setGmao($gmao)
    {
        $this->gmao = $gmao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisco()
    {
        return $this->disco;
    }

    /**
     * @param mixed $disco
     * @return TranscoOptic
     */
    public function setDisco($disco)
    {
        $this->disco = $disco;
        return $this;
    }
}

