<?php

namespace TranscoBundle\DataFixtures\ORM;

use Apoutchika\LoremIpsumBundle\Services\LoremIpsum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TranscoBundle\Entity\TranscoNatureInter;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadTranscoNatureInterdData implements FixtureInterface, ContainerAwareInterface
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
            $transcoNatureInter = new TranscoNatureInter();

            $transcoNatureInter->setOpticNatCode($loremIpsum->getWords(1));
            $transcoNatureInter->setOpticSkill($loremIpsum->getWords(3));
            $transcoNatureInter->setOpticNatLabel($loremIpsum->getWords(3));
            $transcoNatureInter->setPictrelNatOpCode($loremIpsum->getWords(1));
            $transcoNatureInter->setPictrelNatOpLabel($loremIpsum->getWords(3));
            $transcoNatureInter->setTroncatedPictrelNatOpLabel($loremIpsum->getWords(3));
            $transcoNatureInter->setCounter($i + 1);

            $manager->persist($transcoNatureInter);
        }

        $manager->flush();
    }
}