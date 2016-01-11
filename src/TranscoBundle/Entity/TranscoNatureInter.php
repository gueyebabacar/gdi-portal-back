<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;

/**
 * TranscoNatureInter
 *
 * @ORM\Table(name="transco_nature_inter")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoNatureInterRepository")
 */
class TranscoNatureInter
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
     * Code nature intervention OPTIC
     *
     * @var $opticNatCode
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $opticNatCode;

    /**
     * Competence
     *
     * @var $opticSkill
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $opticSkill;

    /**
     * Libelle nature intervention
     *
     * @var $opticNatLabel
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $opticNatLabel;

    /**
     * Code NatOp
     *
     * @var $pictrelNatOpCode
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $pictrelNatOpCode;

    /**
     * Libelle NatOp
     *
     * @var $pictrelNatOpLabel
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $pictrelNatOpLabel;

    /**
     * Libelle NatOp tronqué
     *
     * @var $troncatedPictrelNatOpLabel
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $troncatedPictrelNatOpLabel;

    /**
     * app
     *
     * @var $counter
     * @ORM\Column(type="integer", nullable=true)
     * @Expose
     */
    protected $counter;

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
    public function getOpticNatCode()
    {
        return $this->opticNatCode;
    }

    /**
     * @param mixed $opticNatCode
     * @return $this
     */
    public function setOpticNatCode($opticNatCode)
    {
        $this->opticNatCode = $opticNatCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpticSkill()
    {
        return $this->opticSkill;
    }

    /**
     * @param mixed $opticSkill
     * @return $this
     */
    public function setOpticSkill($opticSkill)
    {
        $this->opticSkill = $opticSkill;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpticNatLabel()
    {
        return $this->opticNatLabel;
    }

    /**
     * @param mixed $opticNatLabel
     * @return $this
     */
    public function setOpticNatLabel($opticNatLabel)
    {
        $this->opticNatLabel = $opticNatLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPictrelNatOpCode()
    {
        return $this->pictrelNatOpCode;
    }

    /**
     * @param mixed $pictrelNatOpCode
     * @return $this
     */
    public function setPictrelNatOpCode($pictrelNatOpCode)
    {
        $this->pictrelNatOpCode = $pictrelNatOpCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPictrelNatOpLabel()
    {
        return $this->pictrelNatOpLabel;
    }

    /**
     * @param mixed $pictrelNatOpLabel
     * @return $this
     */
    public function setPictrelNatOpLabel($pictrelNatOpLabel)
    {
        $this->pictrelNatOpLabel = $pictrelNatOpLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTroncatedPictrelNatOpLabel()
    {
        return $this->troncatedPictrelNatOpLabel;
    }

    /**
     * @param mixed $troncatedPictrelNatOpLabel
     * @return $this
     */
    public function setTroncatedPictrelNatOpLabel($troncatedPictrelNatOpLabel)
    {
        $this->troncatedPictrelNatOpLabel = $troncatedPictrelNatOpLabel;
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
}

