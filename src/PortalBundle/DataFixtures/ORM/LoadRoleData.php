<?php

namespace PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortalBundle\Entity\Role;


class LoadRoleData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 8; $i++) {
            $role = new Role();
            switch ($i) {
                case 0:
                    $role->setLabel('Programmateur');
                    $role->setCode('PROGRAMMATEUR');
                    $this->addReference('role-programmateur', $role);
                    break;
                case 1:
                    $role->setLabel('Programmateur avancé');
                    $role->setCode('PROGRAMMATEUR_AVANCEE');
                    break;
                case 2:
                    $role->setLabel('Manager APPO');
                    $role->setCode('MANAGER_APPO');
                    break;
                case 3:
                    $role->setLabel('Référent Equipe');
                    $role->setCode('REFERENT_EQUIPE');
                    $this->addReference('role-referent-equipe', $role);
                    break;
                case 4:
                    $role->setLabel('Manager ATG');
                    $role->setCode('MANAGER_ATG');
                    $this->addReference('role-manager-atg', $role);
                    break;
                case 4:
                    $role->setLabel('Visiteur "étendu"');
                    $role->setCode('VISITEUR_ETENDU');
                    break;
                case 5:
                    $role->setLabel('Visiteur (rôle par défaut)');
                    $role->setCode('VISITEUR');
                    break;
                case 6:
                    $role->setLabel('Administrateur local');
                    $role->setCode('ADMINISTRATEUR_LOCAL');
                    break;
                case 7:
                    $role->setLabel('Administrateur National');
                    $role->setCode('ADMINISTRATEUR_NATIONAL');
                    $this->addReference('role-admin-nat', $role);
                    break;
            }
            $manager->persist($role);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}