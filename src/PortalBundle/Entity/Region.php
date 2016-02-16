<?php

namespace PortalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="regions")
 */
class Region extends TerritorialEntity
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Agency", mappedBy="region")
     */
    protected $agencies;

    public function __construct()
    {
        $this->agencies = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAgencies()
    {
        return $this->agencies;
    }

    /**
     * @param $agency
     * @return $this
     */
    public function addAgency(Agency $agency = null)
    {
        if ($agency != null && !$this->agencies->contains($agency)) {
            $this->agencies->add($agency);
            $agency->setRegion($this);
        }
        return $this;
    }

    /**
     * @param $agency
     * @return $this
     */
    public function removeAgency(Agency $agency = null)
    {
        if ($agency != null && $this->agencies->contains($agency)) {
            $this->agencies->removeElement($agency);
            $agency->setRegion(null);
        }
        return $this;
    }


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Agency", mappedBy="region")
     */
    protected $agencies;

    /**
     * Region constructor.
     */
    public function __construct()
    {
        $this->agencies = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAgencies()
    {
        return $this->agencies;
    }

    /**
     * @param $agency
     * @return $this
     */
    public function addAgency($agency)
    {
        $this->agencies->add($agency);
        return $this;
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Agency", mappedBy="region")
     */
    protected $agencies;

    /**
     * Region constructor.
     */
    public function __construct()
    {
        $this->agencies = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAgencies()
    {
        return $this->agencies;
    }

    /**
     * @param $agency
     * @return $this
     */
    public function addAgency($agency)
    {
        $this->agencies->add($agency);
        return $this;
    }

}