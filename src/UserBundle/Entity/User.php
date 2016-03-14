<?php

namespace UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping\AttributeOverrides;
use Doctrine\ORM\Mapping\AttributeOverride;
use UserBundle\Enum\ContextEnum;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Enum\EntityEnum;
use PortalBundle\Entity\Region;
use PortalBundle\Entity\Agency;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @AttributeOverrides({
 *     @AttributeOverride(name="password",
 *         column=@ORM\Column(
 *             nullable=true
 *        )
 *     ),
 *     @AttributeOverride(name="email",
 *         column=@ORM\Column(
 *             nullable=true
 *        )
 *     ),
 *     @AttributeOverride(name="emailCanonical",
 *         column=@ORM\Column(
 *             nullable=true
 *        )
 *     )
 * })
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
     * @var Agency
     *
     * @ORM\ManyToOne(targetEntity="PortalBundle\Entity\Agency")
     */
    protected $agency;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="PortalBundle\Entity\Region")
     */
    protected $region;

    /**
     * Maille
     *
     * @var $territorialContext
     *
     * @ORM\Column(type="string")
     */
    protected $territorialContext;

    /**
     * Code Maille
     *
     * @var $territorialContext
     *
     * @ORM\Column(type="string" , nullable=true)
     */
    protected $territorialCode;

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
        if (!in_array($entity, EntityEnum::getEntities())) {
            throw new \InvalidArgumentException("Entité invalide");
        }
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
        $this->setTerritorialContext(ContextEnum::AGENCY_CONTEXT);
        if (is_null($this->agency )) {
            return;
        }else{
            $this->setTerritorialCode($this->agency->getCode());
        }
        return $this;
    }

    /**
     * @return Region
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
        $this->setTerritorialContext(ContextEnum::REGION_CONTEXT);
        if (is_null($this->region)) {
            return;
        }else{
            $this->setTerritorialCode($this->region->getCode());
        }
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
    public function getTerritorialCode()
    {
        return $this->territorialCode;
    }

    /**
     * @param mixed $territorialCode
     * @return $this
     */
    public function setTerritorialCode($territorialCode = null)
    {
        $this->territorialCode = $territorialCode;
        return $this;
    }

    public function setSalt($salt){
        $this->salt = $salt;
        return $this;
    }

    /**
     * @return array
     */
    public function getArrayContext()
    {
        $maille = $this->getTerritorialContext();
        $code_maille = $this->getTerritorialCode();
        return [
            'maille' => $maille,
            'code_maille' => $code_maille
        ];
    }

    /**
     * @return array
     */
    public static function getContexts()
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
    public static function getEntities()
    {
        return [
            EntityEnum::APPO_ENTITY,
            EntityEnum::ATG_ENTITY,
            EntityEnum::VISITOR_ENTITY
        ];
    }
}