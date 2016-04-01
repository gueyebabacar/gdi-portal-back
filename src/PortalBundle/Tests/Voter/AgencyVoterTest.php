<?php

namespace PortalBundle\Tests\Voter;

use Prophecy\Prophet;
use UserBundle\Entity\User;
use PortalBundle\Enum\VoterEnum;
use Prophecy\Prophecy\ObjectProphecy;
use PortalBundle\Tests\BaseWebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AgencyVoterTest extends BaseWebTestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    private $tokenInterfaceProphecy;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->prophet = new Prophet();

    }

    /**
     * @test
     * testSupports
     */
    public function testSupports()
    {
        $data = [
            'view_index' => 'view',
            'edit_index' => 'edit',
            'delete_index' => 'delete'
        ];

        $array = VoterEnum::getActions();

        $this->assertContains($data['view_index'], $array);
        $this->assertContains($data['edit_index'], $array);
        $this->assertContains($data['delete_index'], $array);

    }

    /**
     * @test
     * testVoteOnAttribute
     */
    public function testVoteOnAttribute()
    {
        $tokenInterfaceProphecy = $this->prophet->prophesize(TokenInterface::class);

        $tokenInterfaceProphecy
            ->getUser()
            ->willReturn()
            ->shouldBeCalled();

    }
}
