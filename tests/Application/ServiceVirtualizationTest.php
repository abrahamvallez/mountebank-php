<?php

namespace MountebankPHP\Tests\Application;

use MountebankPHP\Application\ServiceVirtualization;
use MountebankPHP\Domain\Imposter;
use MountebankPHP\Domain\ImposterFormatter;
use MountebankPHP\Infrastructure\Http\HttpClient;
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
        $this->httpClientMock = $this->getMockBuilder('MountebankPHP\Infrastructure\Http\HttpClient')
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
        $imposter = $this->getImporterMock();
        $imposterData = json_encode([
            'protocol' => Imposter::HTTP_PROTOCOL,
            'port' => '4545',
            'stubs' => []
        ]);
        $correctOptions = [
            'headers' => [ServiceVirtualization::CONTENT_TYPE],
            'body' => $imposterData
        ];

        $imposterFormatterMock = $this->getImposterFormatterMocked($imposter, $imposterData);
        $this->httpClientMock->expects($this->once())
            ->method('post')
            ->with($url . ServiceVirtualization::IMPOSTER_URI, $correctOptions);


        $serviceVirtualization = new ServiceVirtualizationMock($this->httpClientMock);
        $serviceVirtualization->setImposterFormatter($imposterFormatterMock);
        $serviceVirtualization->setServiceHost($url);
        $serviceVirtualization->setImposterInService($imposter);
    }

    /**
     * Test setImpostorInService throws exception if post call fails.
     */
    public function testSetImpostorInServiceThrowExceptionIfPostCallFail()
    {
        $this->httpClientMock->expects($this->once())
            ->method('post')
            ->willThrowException(new RuntimeException);

        $imposter = new Imposter();
        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);

        $this->setExpectedException('RuntimeException');
        $serviceVirtualization->setImposterInService($imposter);
    }

    /**
     * Test removeImpostorInService do delete call with correct params.
     */
    public function testRemoveImpostorInServiceDoDeleteCallWithCorrectParams()
    {
        $url = 'http://servicehost.is.a.string';
        $correctPortToDelete = 4545;
        $imposter = $this->getImporterMock();

        $this->httpClientMock->expects($this->once())
            ->method('delete')
            ->with($url . ServiceVirtualization::IMPOSTER_URI . '/' . $correctPortToDelete);

        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);
        $serviceVirtualization->setServiceHost($url);
        $serviceVirtualization->removeImposterInService($imposter);
    }

    /**
     * Test removeImpostorInService throws exception if delete call fails.
     */
    public function testRemoveImpostorInServiceThrowExceptionIfDeleteCallFail()
    {
        $imposter = $this->getImporterMock();

        $this->httpClientMock->expects($this->once())
            ->method('delete')
            ->willThrowException(new RuntimeException);

        $serviceVirtualization = new ServiceVirtualization($this->httpClientMock);
        $this->setExpectedException('RuntimeException');
        $serviceVirtualization->removeImposterInService($imposter);
    }

    /**
     * @return Imposter
     */
    protected function getImporterMock()
    {
        $imposter = new Imposter();
        $imposter->setProtocol(Imposter::HTTP_PROTOCOL);
        $imposter->setPort('4545');

        return $imposter;
    }

    /**
     * @param $imposter
     * @param $imposterData
     *
     * @return ImposterFormatter|PHPUnit_Framework_MockObject_MockObject
     */
    protected function getImposterFormatterMocked($imposter, $imposterData)
    {
        /** @var ImposterFormatter | PHPUnit_Framework_MockObject_MockObject $imposterFormatterMock */
        $imposterFormatterMock = $this->getMockBuilder('Mountebank\Domain\ImposterFormatter')
            ->disableOriginalConstructor()
            ->setMethods(['getJsonImposter'])
            ->getMock();

        $imposterFormatterMock->expects($this->once())
            ->method('getJsonImposter')
            ->with($imposter)
            ->willReturn($imposterData);

        return $imposterFormatterMock;
    }
}
