<?php

namespace TranscoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranscoGmao
 *
 * @ORM\Table(name="transco_gmao")
 * @ORM\Entity()
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

    /**how
     * type de travail
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $workType;

    /**
     * groupe de gamme
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $groupGame;

    /**
     * compteur
     *
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $counter;

    /**
     * $optic
     *
     * @var TranscoOptic
     * @ORM\OneToOne(targetEntity="TranscoOptic", mappedBy="gmao")
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

