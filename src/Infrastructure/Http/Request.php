<?php

namespace MountebankPHP\Infrastructure\Http;

use MountebankPHP\Domain\Http\RequestInterface;
use GuzzleHttp\Message\Request as GuzzleRequest;

/**
 * Class Request
 */
class Request extends GuzzleRequest implements RequestInterface
{

}