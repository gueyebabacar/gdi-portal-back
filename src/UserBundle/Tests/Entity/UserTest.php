<?php

namespace UserBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     */
    public function testGettersAndSetters()
    {
        $agency = new Agency();

        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'entity' => 'entity',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'territorialContext' => 'AGENCE',
            'agency' => $agency,
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEntity($data['entity']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setRoles($data['roles']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);

        $this->assertEquals($user->getFirstName(),$data['firstName']);
        $this->assertEquals($user->getLastName(),$data['lastName']);
        $this->assertEquals($user->getNni(),$data['nni']);
        $this->assertEquals($user->getPhone1(),$data['phone1']);
        $this->assertEquals($user->getPhone2(),$data['phone2']);
        $this->assertEquals($user->getTerritorialContext(),$data['territorialContext']);
        $this->assertEquals($user->getAgency(),$data['agency']);
    }
}
