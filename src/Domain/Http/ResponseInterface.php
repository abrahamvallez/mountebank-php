<?php

namespace MountebankPHP\Domain\Http;

/**
 * Interface ResponseInterface
 */
interface ResponseInterface
{
    /**
     * @return string
     */
    public function getStatusCode();

    /**
     * @return string
     */
    public function getBody();
}