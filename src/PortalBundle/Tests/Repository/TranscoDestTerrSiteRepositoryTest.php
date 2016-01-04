<?php
namespace PortalBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TranscoDestTerrSiteRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }


    public function testFindByIdRefOp()
    {
        $this->markTestSkipped();
        $destinataireSite = $this->em
            ->getRepository('PortalBundle:TranscoDestTerrSite')
            ->findByIdRefOp('055')
        ;

        $this->assertCount(1, $destinataireSite);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
    }
}