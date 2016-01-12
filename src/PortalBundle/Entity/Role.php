<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoDestTerrSite
 *
 * @ORM\Table(name="transco_dest_terr_site")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoDestTerrSiteRepository")
 */
class Role
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * label
     *
     * @var $label
     * @ORM\Column(type="string")
     */
    protected $label;


    /**
     * code
     *
     * @var $code
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return role
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return role
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return role
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }


}

