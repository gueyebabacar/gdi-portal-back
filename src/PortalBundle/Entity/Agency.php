<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="agencies")
 */
class Agency extends TerritorialEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="Region")
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