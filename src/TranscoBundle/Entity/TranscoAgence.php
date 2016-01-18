<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;

/**
 * TranscoAgence
 *
 * @ORM\Table(name="transco_agence")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoAgenceRepository")
 */
class TranscoAgence
{
    const CODE_AGENCE = "CodeAgence";
    const CENTRE = "Centre";

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
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $inseeCode;

    /**
     * code agence
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $codeAgence;

    /**
     * Libelle agence
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $agenceLabel;

    /**
     * center
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $center;

    /**
     * destinataire
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Expose
     */
    protected $destinataire;

    /**
     * Pr
     *
     * @var string
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
     * @return TranscoAgence
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getInseeCode()
    {
        return $this->inseeCode;
    }

    /**
     * @param string $inseeCode
     * @return TranscoAgence
     */
    public function setInseeCode($inseeCode)
    {
        $this->inseeCode = $inseeCode;
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
     * @return TranscoAgence
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
     * @return TranscoAgence
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
     * @return TranscoAgence
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
     * @return TranscoAgence
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
     * @return TranscoAgence
     */
    public function setPr($pr)
    {
        $this->pr = $pr;
        return $this;
    }
}

