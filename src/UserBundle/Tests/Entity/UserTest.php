<?php

namespace UserBundle\Tests\Entity;

use PortalBundle\Entity\Agency;
use UserBundle\Entity\User;
use UserBundle\Enum\RolesEnum;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test testGettersAndSetters
     * @group entity
     */
    public function testGettersAndSetters()
    {
        $agency = new Agency();
        $agency->setCode('codeAgence');

        $data = [
            'firstName' => 'fistName',
            'lastName' => 'lastName',
            'gaia' => 'gaia',
            'email' => 'email',
            'entity' => 'APPI',
            'password' => 'password',
            'nni' => 'nni',
            'phone1' => 'phone1',
            'phone2' => 'phone2',
            'roles' => [RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL],
            'territorialContext' => 'AGENCE',
            'agency' => $agency,
        ];

        $arrayContext = [
            'maille' => 'AGENCE',
            'code_maille' => $agency->getCode()
        ];

        $contexts = [
            'REGION',
            'AGENCE',
            'NATIONAL',
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
        $user->setEntity($data['entity']);

        $this->assertEquals($data['firstName'], $user->getFirstName());
        $this->assertEquals($data['lastName'], $user->getLastName());
        $this->assertEquals($data['nni'], $user->getNni());
        $this->assertEquals($data['phone1'], $user->getPhone1());
        $this->assertEquals($data['phone2'], $user->getPhone2());
        $this->assertEquals($data['territorialContext'], $user->getTerritorialContext());
        $this->assertEquals($data['agency'], $user->getAgency());
        $this->assertEquals($data['entity'], $user->getEntity());

        $this->assertEquals($arrayContext, $user->getArrayContext());
        $this->assertEquals($contexts, User::getContexts());
    }
}
