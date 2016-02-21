<?php

namespace MountebankPHP\Infrastructure\Http;

use GuzzleHttp\Message\Response as GuzzleResponse;
use MountebankPHP\Domain\Http\ResponseInterface;

/**
 * Class Response
 */
class Response extends GuzzleResponse implements ResponseInterface
{

}