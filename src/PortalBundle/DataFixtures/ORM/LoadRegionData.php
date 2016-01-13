<?php

namespace PortalBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PortalBundle\Entity\Region;

class LoadRegionData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 5; $i++) {
            $region = new Region();
            $region->setLabel('Region ' . $i);
            $region->setCode('REG' . $i);
            $manager->persist($region);
            $this->addReference('region-' . $i, $region);
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
        return 1;
    }
}