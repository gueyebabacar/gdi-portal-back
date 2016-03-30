<?php

namespace PortalBundle\Tests\Service;

use PortalBundle\Service\ErrorService;

class ErrorServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var  ErrorService
     */
    private $errorService;

    /**
     * setUp
     */
    public function setUp()
    {
        parent::setUp();

        $this->errorService = new ErrorService();
    }

    /**
     * @test
     * testGetErrors
     */

    public function testGetErrors()
    {
        $this->assertFalse($this->errorService->getErrors()['hasError']);
    }

    /**
     * @test
     * testGetTotalError
     */

    public function testGetTotalError()
    {
        $totalError = 0;
        $this->assertTrue($this->errorService->getTotalError() > $totalError);
    }

    /**
     * @test
     * testGetHasError
     */

    public function testGetHasError()
    {
        $this->assertTrue($this->errorService->getHasError());
    }

    /**
     * @test
     * testresetScopeError
     */

    public function testresetScopeError()
    {
        $this->assertFalse($this->errorService->getScopeError());
    }
}
