<?php

namespace MountebankPHP\Infrastructure\Http;

use GuzzleHttp\Client;
use MountebankPHP\Domain\Http\HttpClientInterface;

/**
 * Class HttpClient
 */
class HttpClient extends Client implements HttpClientInterface
{

}