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
            $transcoDestTerrSite->setTerritory($i);
            $transcoDestTerrSite->setAdressee(strtoupper($loremIpsum->getWords(1)));
            $transcoDestTerrSite->setSite(strtoupper($loremIpsum->getWords(1)));
            $transcoDestTerrSite->setPr(strtoupper($loremIpsum->getWords(1)));
            $transcoDestTerrSite->setIdRefStructureOp("ATG" . $i);

            $manager->persist($transcoDestTerrSite);
        }

        $manager->flush();
    }
}