<?php

namespace PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="PortalBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    const REGION_CONTEXT = 'reg';
    const AGENCY_CONTEXT = 'age';
    const NATIONAL_CONTEXT = 'nat';

    /**
     * @var $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $firstName
     *
     * @ORM\Column(name="prenom", type="string")
     */
    protected $firstName;

    /**
     * @var $lastName
     *
     * @ORM\Column(name="nom", type="string")
     */
    protected $lastName;

    /**
     * @var $email
     *
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var $email
     *
     * @ORM\Column(type="string")
     */
    protected $entity;

    /**
     * @var $gaia
     *
     * @ORM\Column(type="string")
     */
    protected $gaia;

    /**
     * @var $nni
     *
     * @ORM\Column(type="string")
     */
    protected $nni;

    /**
     * @var $phone1
     *
     * @ORM\Column(type="string")
     */
    protected $phone1;

    /**
     * @var $phone2
     *
     * @ORM\Column(type="string")
     */
    protected $phone2;

    /**
     * @var $role
     *
     * @ORM\Column(type="string")
     */
    protected $role;

    /**
     * Agency
     * @var $agency
     * @ORM\ManyToOne(targetEntity="Agency")
     */
    protected $agency;

    /**
     * Region
     * @var $region
     * @ORM\ManyToOne(targetEntity="Region")
     */
    protected $region;

    /**
     * @ORM\Column(type="string")
     * @var $territorialContext
     */
    protected $territorialContext;

    public function __construct()
    {
        parent::__construct();
        $this->setTerritorialContext($this::NATIONAL_CONTEXT);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGaia()
    {
        return $this->gaia;
    }

    /**
     * @param mixed $gaia
     * @return $this
     */
    public function setGaia($gaia)
    {
        $this->gaia = $gaia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNni()
    {
        return $this->nni;
    }

    /**
     * @param mixed $nni
     * @return $this
     */
    public function setNni($nni)
    {
        $this->nni = $nni;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * @param mixed $phone1
     * @return $this
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * @param mixed $phone2
     * @return $this
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     * @return $this
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
        $this->region = null;
        $this->setTerritorialContext($this::AGENCY_CONTEXT);
        return $this;
    }

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
        $this->agency = null;
        $this->setTerritorialContext($this::REGION_CONTEXT);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTerritorialContext()
    {
        return $this->territorialContext;
    }

    /**
     * @param mixed $territorialContext
     * @return $this
     */
    public function setTerritorialContext($territorialContext)
    {
        $this->territorialContext = $territorialContext;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrayContext()
    {
        $maille = $this->getTerritorialContext();;
        $code_maille = null;
        if ($this->territorialContext === $this::AGENCY_CONTEXT) {
            $code_maille = $this->getAgency()->getCode();
        } elseif ($this->territorialContext === $this::REGION_CONTEXT){
            $code_maille = $this->getRegion()->getCode();
        }
        return [
            'maille' => $maille,
            'code_maille' => $code_maille
        ];
    }

    /**
     * @return array
     */
    public function getContexts()
    {
        return [
            $this::REGION_CONTEXT,
            $this::AGENCY_CONTEXT,
            $this::NATIONAL_CONTEXT
        ];
    }
}