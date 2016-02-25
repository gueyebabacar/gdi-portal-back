<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\AgencyRepository")
 * @ORM\Table(name="agencies")
 */
class Agency extends TerritorialEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="agencies")
     */
    protected $region;

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }
}