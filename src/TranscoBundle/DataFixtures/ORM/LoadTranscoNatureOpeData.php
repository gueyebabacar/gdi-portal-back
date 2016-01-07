<?php

namespace TranscoBundle\DataFixtures\ORM;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TranscoBundle\Entity\TranscoNatureOpe;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadTranscoNatureOpeData implements FixtureInterface, ContainerAwareInterface
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

        for($i = 0; $i < 20; $i++){
            $transcoNatureOpe = new TranscoNatureOpe();

            $transcoNatureOpe->setWorkType($loremIpsum->getWords(1));
            $transcoNatureOpe->setGammeGroup(strtoupper($loremIpsum->getWords(1)));
            $transcoNatureOpe->setPurpose($loremIpsum->getWords(1));
            $transcoNatureOpe->setCounter($i + 1);
            $transcoNatureOpe->setSegmentationValue($loremIpsum->getWords(3));
            $transcoNatureOpe->setSegmentationName($loremIpsum->getWords(3));
            $transcoNatureOpe->setProgrammingMode($loremIpsum->getWords(3));
            $transcoNatureOpe->setNatureInterCode(strtoupper($loremIpsum->getWords(1)));

            $manager->persist($transcoNatureOpe);
        }

        $manager->flush();
    }
}