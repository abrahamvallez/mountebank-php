<?php

namespace MountebankPHP\Domain\Http;

/**
 * Interface RequestExceptionInterface
 */
interface RequestExceptionInterface
{
    /**
     * Get Message
     *
     * @return string
     */
    public function getMessage();

    /**
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * @return ResponseInterface
     */
    public function getResponse();
}