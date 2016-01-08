<?php

namespace TranscoBundle\DataFixtures\ORM;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TranscoBundle\Entity\TranscoDestTerrSite;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadTranscoDestTerrSiteData implements FixtureInterface, ContainerAwareInterface
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

        for ($i = 0; $i < 20; $i++) {
            $transcoDestTerrSite = new TranscoDestTerrSite();
            $number = rand(0, 100);
            $transcoDestTerrSite->setTerritory($number);
            $transcoDestTerrSite->setAdressee(strtoupper($loremIpsum->getWords(1)));
            $transcoDestTerrSite->setSite(strtoupper($loremIpsum->getWords(1)));
            $transcoDestTerrSite->setPr(strtoupper($loremIpsum->getWords(1)));
            $transcoDestTerrSite->setIdRefStructureOp("ATG" . $number);

            $manager->persist($transcoDestTerrSite);
        }

        $manager->flush();
    }
}