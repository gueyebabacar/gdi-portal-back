<?php

namespace PortalBundle\DataFixtures\ORM;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortalBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setFirstName(ucfirst($loremIpsum->getWords(1)));
            $user->setLastName(ucfirst($loremIpsum->getWords(1)));
            $user->setEmail(lcfirst($user->getFirstName()) . '.' . lcfirst($user->getLastName()) . '@grdf.fr');
            $user->setEntity(strtoupper($loremIpsum->getWords(1)));
            $user->setGaia('GAIA' . $i);
            $user->setNni('NNI' . $i);
            $user->setPhone1('+33111111' . $i);
            $user->setPhone2('+33111112' . $i);
            $user->setRole(strtoupper($loremIpsum->getWords(1)));

            switch($i){
                case 0:
                    break;
                case 1:
                    $user->setAgency($this->getReference('agency-1'));
                    break;
                case 2:
                    $user->setRegion($this->getReference('region-4'));
                    break;
                case 3:
                    $user->setAgency($this->getReference('agency-4'));
                    break;
                case 4:
                    $user->setRegion($this->getReference('region-3'));
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