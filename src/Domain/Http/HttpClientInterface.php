<?php

namespace MountebankPHP\Domain\Http;

/**
 * Interface HttpClientInterface
 *
 */
interface HttpClientInterface
{
    /**
     * Send a POST request
     *
     * @param string    $url     URL.
     * @param array     $options Array of request options to apply.
     *
     * @return ResponseInterface
     * @throws RequestExceptionInterface When an error is encountered
     */
    public function post($url = null, array $options = []);

    /**
     * Send a DELETE request
     *
     * @param string    $url     URL.
     * @param array     $options Array of request options to apply.
     *
     * @return ResponseInterface
     * @throws RequestExceptionInterface When an error is encountered
     */
    public function delete($url = null, array $options = []);
}