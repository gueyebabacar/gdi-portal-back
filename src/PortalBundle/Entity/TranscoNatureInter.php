<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoNatureInter
 *
 * @ORM\Table(name="transco_nature_inter")
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\TranscoNatureInterRepository")
 */
class TranscoNatureInter
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Code nature intervention OPTIC
     *
     * @var $opticNatCode
     * @ORM\Column(type="string")
     */
    protected $opticNatCode;

    /**
     * Competence
     *
     * @var $opticSkill
     * @ORM\Column(type="string")
     */
    protected $opticSkill;

    /**
     * Libelle nature intervention
     *
     * @var $opticNatLabel
     * @ORM\Column(type="string")
     */
    protected $opticNatLabel;

    /**
     * Code NatOp
     *
     * @var $pictrelNatOpCode
     * @ORM\Column(type="string")
     */
    protected $pictrelNatOpCode;

    /**
     * Libelle NatOp
     *
     * @var $pictrelNatOpLabel
     * @ORM\Column(type="string")
     */
    protected $pictrelNatOpLabel;

    /**
     * Libelle NatOp tronqué
     *
     * @var $troncatedPictrelNatOpLabel
     * @ORM\Column(type="string")
     */
    protected $troncatedPictrelNatOpLabel;

    /**
     * app
     *
     * @var $app
     * @ORM\Column(type="string")
     */
    protected $app;

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
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @param mixed $app
     * @return $this
     */
    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }
}

