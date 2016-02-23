<?php

namespace MountebankPHP\Infrastructure\Http;

use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use MountebankPHP\Domain\Http\RequestExceptionInterface;

/**
 * Class RequestException
 */
class RequestException extends GuzzleRequestException implements RequestExceptionInterface
{

}