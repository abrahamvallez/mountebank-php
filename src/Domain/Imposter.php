<?php

namespace MountebankPHP\Domain;

/**
 * Class Impostor
 */
class Imposter
{
    /**
     * @const string
     */
    const HTTP_PROTOCOL = 'http';

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var array
     */
    protected $stubs;

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     *
     * @return Imposter
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     *
     * @return Imposter
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return array
     */
    public function getStubs()
    {
        return $this->stubs;
    }

    /**
     * @param Stub $stub
     *
     * @return Imposter
     */
    public function addStub(Stub $stub)
    {
        $this->stubs[] = $stub;

        return $this;
    }
}