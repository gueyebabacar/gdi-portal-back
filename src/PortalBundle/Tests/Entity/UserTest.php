<?php

namespace PortalBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use PortalBundle\Entity\Role;
use UserBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     */
    public function testGettersAndSetters()
    {
        $agency = new Agency();
        $role = new Role();

        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'gaia' => 'gaia',
            'email' => 'entity',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'role' => $role,
            'territorialContext' => 'age',
            'agency' => $agency,
        ];

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setEntity($data['email']);
        $user->setUsername($data['gaia']);
        $user->setNni($data['nni']);
        $user->setPhone1($data['phone1']);
        $user->setPhone2($data['phone2']);
        $user->setRole($data['role']);
        $user->setTerritorialContext($data['territorialContext']);
        $user->setAgency($data['agency']);

        $this->assertEquals($user->getFirstName(),$data['firstName']);
        $this->assertEquals($user->getLastName(),$data['lastName']);
        $this->assertEquals($user->getEmail(),$data['email']);
        $this->assertEquals($user->getUsername(),$data['gaia']);
        $this->assertEquals($user->getNni(),$data['nni']);
        $this->assertEquals($user->getPhone1(),$data['phone1']);
        $this->assertEquals($user->getPhone2(),$data['phone2']);
        $this->assertEquals($user->getRole(),$data['role']);
        $this->assertEquals($user->getTerritorialContext(),$data['territorialContext']);
        $this->assertEquals($user->getAgency(),$data['agency']);
    }
}
