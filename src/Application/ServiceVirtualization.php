<?php

namespace MountebankPHP\Application;

use MountebankPHP\Domain\Http\HttpClientInterface;
use MountebankPHP\Domain\Imposter;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\Response;
use InvalidArgumentException;
use MountebankPHP\Domain\ImposterFormatter;
use RuntimeException;

/**
 * Class ServiceVirtualization
 */
class ServiceVirtualization
{
    /**
     * @const string
     */
    const CONTENT_TYPE = 'Content-Type: application/json';

    /**
     * @const string
     */
    const IMPOSTER_URI = '/imposters';

    /**
     * @var string
     */
    protected $serviceHost;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    protected $imposterFormatter;

    /**
     * ServiceVirtualization constructor.
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->imposterFormatter = new ImposterFormatter();
    }

    /**
     * Get Service Host.
     *
     * @return string
     */
    public function getServiceHost()
    {
        return $this->serviceHost;
    }

    /**
     * Set Service Host.
     *
     * @param string $serviceHost
     */
    public function setServiceHost($serviceHost)
    {
        if (!is_string($serviceHost)) {
            throw new InvalidArgumentException('Service host must be a string');
        }

        $this->serviceHost = $serviceHost;
    }

    /**
     * Set imposter in service.
     *
     * @param Imposter $imposter
     *
     * @return Response
     */
    public function setImposterInService(Imposter $imposter)
    {
        $postOptions = [
            'body' => $this->imposterFormatter->getJsonImposter($imposter)
        ];
        $this->httpClient->post($this->serviceHost, $postOptions);
    }

    /**
     * Remove imposter in service.
     *
     * @param Imposter $imposter
     *
     * @return boolean
     */
    public function removeImposterInService(Imposter $imposter)
    {
        try {
            $deleteUrl = $this->serviceHost . $this::IMPOSTER_URI . '/' . $imposter->getPort();
            return $this->httpClient->delete($deleteUrl);
        } catch (RequestException $exception) {
            $this->manageException($exception);
        }
    }

    /**
     * Manage exception in http call.
     *
     * @param RequestException $exception
     *
     * @throw RuntimeException.
     */
    protected function manageException(RequestException $exception)
    {
        $errorMessage = $exception->getMessage() . ' Request: ' . $exception->getRequest();
        if ($exception->hasResponse()) {
            $errorMessage .= ' ErrorCode: ' . $exception->getResponse()->getStatusCode() .
                ' Response: ' . $exception->getResponse()->getBody();
        }
        throw new RuntimeException($errorMessage);
    }
}