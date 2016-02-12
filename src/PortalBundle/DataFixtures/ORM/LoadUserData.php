<?php

namespace PortalBundle\DataFixtures\ORM;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;
use UserBundle\Enum\EntityEnum;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Enum\RolesEnum;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        /** @var LoremIpsum $loremIpsum */
        $loremIpsum = $this->container->get("apoutchika.lorem_ipsum");

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName(ucfirst($loremIpsum->getWords(1)));
            $user->setLastName(ucfirst($loremIpsum->getWords(1)));
            $user->setEmail(lcfirst($user->getFirstName()) . '.' . lcfirst($user->getLastName()) . '@grdf.fr');
            $user->setUsername('GAIA' . $i);
            $user->setPassword('test');
            $user->setNni('NNI' . $i);
            $user->setPhone1('+33111111' . $i);
            $user->setPhone2('+33111112' . $i);

            switch($i){
                case 0:
                    $user->setEntity(EntityEnum::VISITOR_ENTITY);
                    $user->setAgency($this->getReference('agency-1'));
                    $user->setRoles([RolesEnum::ROLE_VISITEUR]);
                    break;
                case 1:
                    $user->setEntity(EntityEnum::ATG_ENTITY);
                    $user->setAgency($this->getReference('agency-1'));
                    $user->setRoles([RolesEnum::ROLE_TECHNICIEN]);
                    break;
                case 2:
                    $user->setEntity(EntityEnum::APPO_ENTITY);
                    $user->setRegion($this->getReference('region-4'));
                    $user->setRoles([RolesEnum::ROLE_PROGRAMMATEUR]);
                    break;
                case 3:
                    $user->setEntity(EntityEnum::ATG_ENTITY);
                    $user->setAgency($this->getReference('agency-4'));
                    $user->setRoles([RolesEnum::ROLE_PROGRAMMATEUR_AVANCE]);
                    break;
                case 4:
                    $user->setEntity(EntityEnum::APPO_ENTITY);
                    $user->setRegion($this->getReference('region-3'));
                    $user->setRoles([RolesEnum::ROLE_MANAGER_APPO]);
                    break;
                case 5:
                    $user->setEntity(EntityEnum::APPO_ENTITY);
                    $user->setRegion($this->getReference('region-3'));
                    $user->setRoles([RolesEnum::ROLE_REFERENT_EQUIPE]);
                    break;
                case 6:
                    $user->setEntity(EntityEnum::ATG_ENTITY);
                    $user->setAgency($this->getReference('agency-1'));
                    $user->setRoles([RolesEnum::ROLE_MANAGER_ATG]);
                    break;
                case 7:
                    $user->setEntity(EntityEnum::APPO_ENTITY);
                    $user->setRegion($this->getReference('region-4'));
                    $user->setRoles([RolesEnum::ROLE_ADMINISTRATEUR_LOCAL]);
                    break;
                case 8:
                    $user->setEntity(EntityEnum::ATG_ENTITY);
                    $user->setRoles([RolesEnum::ROLE_ADMINISTRATEUR_NATIONAL]);
                    break;
                case 9:
                    $user->setEntity(EntityEnum::APPO_ENTITY);
                    $user->setRoles([RolesEnum::ROLE_ADMINISTRATEUR_SI]);
                    break;
            }
            $manager->persist($user);
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
        return 3;
    }
}