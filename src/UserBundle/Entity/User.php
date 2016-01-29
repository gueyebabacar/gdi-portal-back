<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Region;
use PortalBundle\Entity\Role;
use UserBundle\Enum\ContextEnum;
use UserBundle\Enum\EntityEnum;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string")
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string")
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $entity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nni;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone2;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="PortalBundle\Entity\Role")
     */
    protected $role;

    /**
     * @var Agency
     * @ORM\ManyToOne(targetEntity="PortalBundle\Entity\Agency")
     */
    protected $agency;

    /**
     * Region
     * @var Region
     * @ORM\ManyToOne(targetEntity="PortalBundle\Entity\Region")
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
        $this->setTerritorialContext(ContextEnum::NATIONAL_CONTEXT);
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
     * @return BaseUser
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
     * @return BaseUser
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
     * @return BaseUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
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
     * @return BaseUser
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
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
     * @return BaseUser
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
     * @return BaseUser
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
     * @return BaseUser
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
     * @return BaseUser
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
        $this->region = null;
        $this->setTerritorialContext(ContextEnum::AGENCY_CONTEXT);
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
     * @return BaseUser
     */
    public function setRegion($region)
    {
        $this->region = $region;
        $this->agency = null;
        $this->setTerritorialContext(ContextEnum::REGION_CONTEXT);
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
     * @return BaseUser
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
     * @return BaseUser
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
        if ($this->territorialContext === ContextEnum::AGENCY_CONTEXT) {
            $code_maille = $this->getAgency()->getCode();
        } elseif ($this->territorialContext === ContextEnum::REGION_CONTEXT){
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
            ContextEnum::REGION_CONTEXT,
            ContextEnum::AGENCY_CONTEXT,
            ContextEnum::NATIONAL_CONTEXT
        ];
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return [
            EntityEnum::APPO_ENTITY,
            EntityEnum::ATG_ENTITY,
            EntityEnum::VISITOR_ENTITY
        ];
    }
}