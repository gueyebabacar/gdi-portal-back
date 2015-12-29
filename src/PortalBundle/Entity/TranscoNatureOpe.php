<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;

/**
 * TranscoNatureOpe
 *
 * @ORM\Table(name="transco_nature_ope")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\TranscoNatureOpeRepository")
 */
class TranscoNatureOpe
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
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $workType;

    /**
     * Groupe de gamme
     *
     * @var $gammeGroup
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $gammeGroup;

    /**
     * Compteur
     *
     * @var $counter
     * @ORM\Column(type="integer")
     * @Expose
     */
    protected $counter;

    /**
     * Finalité
     *
     * @var $purpose
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $purpose;

    /**
     * Code Nature Intervention
     *
     * @var $natureInterCode
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $natureInterCode;

    /**
     * Mode de programmation
     *
     * @var $programmingMode
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $programmingMode;

    /**
     * Nom de Segmentation
     *
     * @var $segmentationName
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $segmentationName;

    /**
     * Valeur de Segmentation
     *
     * @var $workType
     * @ORM\Column(type="string")
     * @Expose
     */
    protected $segmentationValue;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
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
     * @return $this
     */
    public function setWorkType($workType)
    {
        $this->workType = $workType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGammeGroup()
    {
        return $this->gammeGroup;
    }

    /**
     * @param mixed $gammeGroup
     * @return $this
     */
    public function setGammeGroup($gammeGroup)
    {
        $this->gammeGroup = $gammeGroup;
        return $this;
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
     * @return $this
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * @param mixed $purpose
     * @return $this
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNatureInterCode()
    {
        return $this->natureInterCode;
    }

    /**
     * @param mixed $natureInterCode
     * @return $this
     */
    public function setNatureInterCode($natureInterCode)
    {
        $this->natureInterCode = $natureInterCode;
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
     * @return $this
     */
    public function setProgrammingMode($programmingMode)
    {
        $this->programmingMode = $programmingMode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmentationName()
    {
        return $this->segmentationName;
    }

    /**
     * @param mixed $segmentationName
     * @return $this
     */
    public function setSegmentationName($segmentationName)
    {
        $this->segmentationName = $segmentationName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSegmentationValue()
    {
        return $this->segmentationValue;
    }

    /**
     * @param mixed $segmentationValue
     * @return $this
     */
    public function setSegmentationValue($segmentationValue)
    {
        $this->segmentationValue = $segmentationValue;
        return $this;
    }
}

