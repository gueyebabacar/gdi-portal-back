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
     * testresetScopeError
     * @test
     * @group errorService
     * @group services
     */
    public function testResetScopeError()
    {
        $this->errorService->resetScopeError();

        $this->assertFalse($this->errorService->getScopeError());
    }

    /**
     * testAddError
     * @test
     * @group errorService
     * @group services
     */
    public function testAddError()
    {
        $message = 'errorMessage';
        $error['message'] = $message;
        $this->errorService->addError(500, 4, $message);
        $this->assertEquals($message, $this->errorService->errors[0]['message']);
    }

    /**
     * testAddErrorKeySet
     * @test
     * @group errorService
     * @group services
     */
    public function testAddErrorKeySet()
    {
        $message = 'errorMessage';
        $error['message'] = 'message';
        $this->errorService->errors[0]['message'] = $message;
        $this->errorService->addError(500, 4, $message);
        $this->assertEquals($message, $this->errorService->errors[0]['message']);
    }

    /**
     * testGetErrors
     * @test
     * @group errorService
     * @group services
     */
    public function testGetErrors()
    {
        $this->assertFalse($this->errorService->getErrors()['hasError']);
    }

    /**
     * testGetTotalError
     * @test
     * @group errorService
     * @group services
     */
    public function testGetTotalError()
    {
        $totalError = 0;
        $this->assertTrue($this->errorService->getTotalError() >= $totalError);
    }

    /**
     * testGetHasError
     * @test
     * @group errorService
     * @group services
     */
    public function testGetHasError()
    {
        $scopeError = 0;
        if ($this->errorService->getHasError() > $scopeError) {
            $this->assertTrue($this->errorService->getHasError());
        } else {
            $this->assertFalse($this->errorService->getHasError());
        }
    }
}
