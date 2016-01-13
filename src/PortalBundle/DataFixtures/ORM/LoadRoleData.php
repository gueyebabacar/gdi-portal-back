<?php

namespace PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortalBundle\Entity\Role;


class LoadRoleData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

            $role = new Role();

            $role->setLabel('Programmateur');
            $role->setCode('PROGRAMMATEUR');
            $manager->persist($role);

            $role1 = new Role();

            $role1->setLabel('Programmateur avancé');
            $role1->setCode('PROGRAMMATEUR_AVANCEE');
            $manager->persist($role1);

            $rolex = new Role();

            $rolex->setLabel('Manager APPO');
            $rolex->setCode('MANAGER_APPO');

            $manager->persist($rolex);

            $role2 = new Role();
            $role2->setLabel('Référent Equipe');
            $role2->setCode('REFERENT_EQUIPE');
            $manager->persist($role2);

            $role3 = new Role();
            $role3->setLabel('Manager ATG');
            $role3->setCode('MANAGER_ATG');
            $manager->persist($role3);

            $role4 = new Role();
            $role4->setLabel('Visiteur "étendu"');
            $role4->setCode('VISITEUR_ETENDU');
            $manager->persist($role4);

            $role5 = new Role();
            $role5->setLabel('Visiteur (rôle par défaut)');
            $role5->setCode('VISITEUR');
            $manager->persist($role5);

            $role6 = new Role();
            $role6->setLabel('Administrateur local');
            $role6->setCode('ADMINISTRATEUR_LOCAL');
            $manager->persist($role6);

            $role7 = new Role();
            $role7->setLabel('Administrateur National');
            $role7->setCode('ADMINISTRATEUR_NATIONAL');
            $manager->persist($role7);

            $manager->flush();
    }
}