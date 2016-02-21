<?php

namespace MountebankPHP\Tests\Application;

use MountebankPHP\Application\ServiceVirtualization;
use MountebankPHP\Domain\Imposter;
use MountebankPHP\Infrastructure\HttpClient;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use RuntimeException;

/**
 * @copyright (C)2015 EnGrande SL
 */
class ServiceVirtualizationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HttpClient | PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpClientMock;

    /**
     * Set up before tests
     */
    public function setUp()
    {
        $httpClientMethods = [
            'delete',
            'post'
        ];
        $this->httpClientMock = $this->getMockBuilder('MountebankPHP\Infrastructure\HttpClient')
            ->disableOriginalConstructor()
            ->setMethods($httpClientMethods)
            ->getMock();
    }

    /**
     * Test serviceHost is null by default.
     */
    public function testServiceHostIsNullByDefault()
    {
        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);

        $this->assertNull($serviceVirtualization->getServiceHost(), 'serviceHost must be null by default');
    }

    /**
     * Test setServiceHost set correctly.
     */
    public function testSetServiceHostSetCorrectly()
    {
        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);

        $serviceHost = 'http://servicehost.is.a.string';
        $serviceVirtualization->setServiceHost($serviceHost);
        $this->assertEquals($serviceHost, $serviceVirtualization->getServiceHost(), 'serviceHost must be set with ' . $serviceHost);
    }

    /**
     * Test setServiceHost throws exception if not string.
     */
    public function testSetServiceHostThrowExceptionIfNotString()
    {
        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);

        $serviceHost = 12354;
        $this->setExpectedException('InvalidArgumentException');
        $serviceVirtualization->setServiceHost($serviceHost);
    }

    /**
     * Test setImpostorInService do post call with correct options.
     */
    public function testSetImpostorInServiceDoPostCallWithCorrectOptions()
    {
        $url = 'http://servicehost.is.a.string';
        $impostorPostData = [
            'port' => 1234,
            'protocol' => 'http',
            'stubs' => [
                [
                    'responses' => 'response_mock_from_stub',
                    'predicates' => 'predicate_mock_from_stub'
                ]
            ]
        ];
        $correctOptions = [
            'headers' => [ServiceVirtualization::CONTENT_TYPE],
            'body' => $impostorPostData
        ];

        $this->httpClientMock->expects($this->once())
            ->method('post')
            ->with($url . ServiceVirtualization::IMPOSTER_URI, $correctOptions);

        /** @var Imposter | PHPUnit_Framework_MockObject_MockObject $impostorMock */
        $impostorMock = $this->getMockBuilder('MountebankPHP\Domain\Impostor')
            ->setMethods(['getJsonDefinition'])
            ->getMock();
        $impostorMock->expects($this->once())
            ->method('getJsonDefinition')
            ->willReturn($impostorPostData);

        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);
        $serviceVirtualization->setServiceHost($url);
        $serviceVirtualization->setImposterInService($impostorMock);
    }

    /**
     * Test setImpostorInService throws exception if post call fails.
     */
    public function testSetImpostorInServiceThrowExceptionIfPostCallFail()
    {
        $this->httpClientMock->expects($this->once())
            ->method('post')
            ->willThrowException(new RuntimeException);

        /** @var Imposter | PHPUnit_Framework_MockObject_MockObject $impostorMock */
        $impostorMock = $this->getMock('MountebankPHP\Domain\Impostor');
        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);

        $this->setExpectedException('RuntimeException');
        $serviceVirtualization->setImposterInService($impostorMock);
    }

    /**
     * Test removeImpostorInService do delete call with correct params.
     */
    public function testRemoveImpostorInServiceDoDeleteCallWithCorrectParams()
    {
        $url = 'http://servicehost.is.a.string';
        $correctPortToDelete = 4545;

        /** @var Imposter | PHPUnit_Framework_MockObject_MockObject $impostorMock */
        $impostorMock = $this->getMockBuilder('MountebankPHP\Domain\Impostor')
            ->setMethods(['getPort'])
            ->getMock();
        $impostorMock->expects($this->any())
            ->method('getPort')
            ->willReturn($correctPortToDelete);

        $this->httpClientMock->expects($this->once())
            ->method('delete')
            ->with($url . ServiceVirtualization::IMPOSTER_URI . '/' . $correctPortToDelete);

        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);
        $serviceVirtualization->setServiceHost($url);
        $serviceVirtualization->removeImposterInService($impostorMock);
    }

    /**
     * Test removeImpostorInService throws exception if delete call fails.
     */
    public function testRemoveImpostorInServiceThrowExceptionIfDeleteCallFail()
    {
        /** @var Imposter | PHPUnit_Framework_MockObject_MockObject$impostorMock */
        $impostorMock = $this->getMockBuilder('MountebankPHP\Domain\Impostor')
            ->setMethods(['getPort'])
            ->getMock();

        $this->httpClientMock->expects($this->once())
            ->method('delete')
            ->willThrowException(new RuntimeException);

        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);
        $this->setExpectedException('RuntimeException');
        $serviceVirtualization->removeImposterInService($impostorMock);
    }
}
