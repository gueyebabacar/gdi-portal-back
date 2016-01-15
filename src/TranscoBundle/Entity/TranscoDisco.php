<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoDisco
 *
 * @ORM\Table(name="transco_disco")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoDiscoRepository")
 */
class TranscoDisco
{
    const CODE_NAT_INT = "CodeNatureIntervention";
    const CODE_FINALITE  = "CodeFinalite";
    const CODE_SEGMENTATION = "CodeSegmentation";

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * disco code objet
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $codeObject;

    /**
     * disco nature operation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $natOp;

    /**
     * disco libelle nature operation
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $natOpLabel;

    /**
     * TranscoOptic
     *
     * @var $optic
     * @ORM\OneToOne(targetEntity="TranscoOptic", inversedBy="TranscoDisco")
     */
    protected $optic;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TranscoDisco
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return TranscoDisco
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
     * @return TranscoDisco
     */
    public function setNatOp($natOp)
    {
        $this->natOp = $natOp;
        return $this;
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
     * @return TranscoDisco
     */
    public function setNatOpLabel($natOpLabel)
    {
        $this->natOpLabel = $natOpLabel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptic()
    {
        return $this->optic;
    }

    /**
     * @param mixed $optic
     * @return TranscoDisco
     */
    public function setOptic($optic)
    {
        $this->optic = $optic;
        return $this;
    }
}

