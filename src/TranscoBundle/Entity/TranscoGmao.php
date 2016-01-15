<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoDestTerrSite
 *
 * @ORM\Table(name="transco_gmao")
 * @ORM\Entity(repositoryClass="TranscoBundle\Repository\TranscoRepository")
 */
class TranscoGmao
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getWorkType()
    {
        return $this->workType;
    }

    /**
     * @param mixed $workType
     * @return TranscoGmao
     */
    public function setWorkType($workType)
    {
        $this->workType = $workType;
        return $this;
    }


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
     * TranscoOptic
     *
     * @var $optic
     * @ORM\OneToOne(targetEntity="TranscoOptic", mappedBy="TranscoGmao")
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
     * @return TranscoGmao
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return TranscoGmao
     */
    public function setGroupGame($groupGame)
    {
        $this->groupGame = $groupGame;
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
     * @return TranscoGmao
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
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
     * @return TranscoGmao
     */
    public function setOptic($optic)
    {
        $this->optic = $optic;
        return $this;
    }
}

