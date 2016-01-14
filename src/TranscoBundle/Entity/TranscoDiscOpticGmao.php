<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoDestTerrSite
 *
 * @ORM\Table(name="transco_disco__optic_gmao")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoDiscOpticGmaoRepository")
 */
class TranscoDiscOpticGmao
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *  This section is for disco
     */

    /**
     * disco code objet
     *
     * @var $codeObject
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $codeObject;

    /**
     * disco nature operation
     *
     * @var $natOp
     * @ORM\Column(type="string", nullable=true)
     */
    protected $natOp;

    /**
     * disco libelle nature operation
     *
     * @var $natOpLabel
     * @ORM\Column(type="string", nullable=true)
     */
    protected $natOpLabel;

    /**
     * End disco section
     */

    /**
     *  Section GMAO
     */

    /**how
     * type de travail
     *
     * @var $workType
     * @ORM\Column(type="string", nullable=true)
     */
    protected $workType;

    /**
     * groupe de gamme
     *
     * @var $groupGame
     * @ORM\Column(type="string", nullable=true)
     */
    protected $groupGame;

    /**
     * compteur
     *
     * @var $counter
     * @ORM\Column(type="string", nullable=true)
     */
    protected $counter;


    /**
     *  Optic section
     */

    /**
     * code type optic
     *
     * @var $codeTypeOptic
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codeTypeOptic;

    /**
     * libellé optic
     *
     * @var $opticLabel
     * @ORM\Column(type="string", nullable=true)
     */
    protected $opticLabel;

    /**
     * code nature intervention
     *
     * @var $codeNatInter
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codeNatInter;

    /**
     * code segmentation
     *
     * @var $segmentationCode
     * @ORM\Column(type="string", nullable=true)
     */
    protected $segmentationCode;

    /**
     * labelle segmentation
     *
     * @var $SegmentationLabel
     * @ORM\Column(type="string", nullable=true)
     */
    protected $SegmentationLabel;

    /**
     * code finalite
     *
     * @var $finalCode
     * @ORM\Column(type="string", nullable=true)
     */
    protected $finalCode;

    /**
     * labelle finalite
     *
     * @var $finalLabel
     * @ORM\Column(type="string", nullable=true)
     */
    protected $finalLabel;

    /**
     * libelle court
     *
     * @var $shortLabel
     * @ORM\Column(type="string", nullable=true)
     */
    protected $shortLabel;

    /**
     * mode de programmation
     *
     * @var $programmingMode
     * @ORM\Column(type="string", nullable=true)
     */
    protected $programmingMode;

    /**
     * mode de
     *
     * @var $calibre
     * @ORM\Column(type="string", nullable=true)
     */
    protected $calibre;

    /**
     * End disco section
     */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TranscoDiscOpticGmao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWorkType()
    {
        return $this->workType;
    }

    /**
     * @param mixed $workType
     */
    public function setWorkType($workType)
    {
        $this->workType = $workType;
    }

    /**
     * @return mixed
     */
    public function getGroupGame()
    {
        return $this->groupGame;
    }

    /**
     * @param mixed $groupGame
     */
    public function setGroupGame($groupGame)
    {
        $this->groupGame = $groupGame;
    }

    /**
     * @return mixed
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param mixed $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

    /**
     * @return mixed
     */
    public function getNatOpLabel()
    {
        return $this->natOpLabel;
    }

    /**
     * @param mixed $natOpLabel
     * @return TranscoDiscOpticGmao
     */
    public function setNatOpLabel($natOpLabel)
    {
        $this->natOpLabel = $natOpLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodeObject()
    {
        return $this->codeObject;
    }

    /**
     * @param mixed $codeObject
     * @return TranscoDiscOpticGmao
     */
    public function setCodeObject($codeObject)
    {
        $this->codeObject = $codeObject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNatOp()
    {
        return $this->natOp;
    }

    /**
     * @param mixed $natOp
     * @return TranscoDiscOpticGmao
     */
    public function setNatOp($natOp)
    {
        $this->natOp = $natOp;
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
     * @return TranscoDiscOpticGmao
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
     * @return TranscoDiscOpticGmao
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
     * @return TranscoDiscOpticGmao
     */
    public function setCodeNatInter($codeNatInter)
    {
        $this->codeNatInter = $codeNatInter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmentationLabel()
    {
        return $this->SegmentationLabel;
    }

    /**
     * @param mixed $SegmentationLabel
     * @return TranscoDiscOpticGmao
     */
    public function setSegmentationLabel($SegmentationLabel)
    {
        $this->SegmentationLabel = $SegmentationLabel;
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
     * @return TranscoDiscOpticGmao
     */
    public function setSegmentationCode($segmentationCode)
    {
        $this->segmentationCode = $segmentationCode;
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
     * @return TranscoDiscOpticGmao
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
     * @return TranscoDiscOpticGmao
     */
    public function setFinalLabel($finalLabel)
    {
        $this->finalLabel = $finalLabel;
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
     * @return TranscoDiscOpticGmao
     */
    public function setProgrammingMode($programmingMode)
    {
        $this->programmingMode = $programmingMode;
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
     * @return TranscoDiscOpticGmao
     */
    public function setShortLabel($shortLabel)
    {
        $this->shortLabel = $shortLabel;
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
     * @return TranscoDiscOpticGmao
     */
    public function setCalibre($calibre)
    {
        $this->calibre = $calibre;
        return $this;
    }


}

