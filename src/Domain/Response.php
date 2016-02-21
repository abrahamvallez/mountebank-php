<?php

namespace MountebankPHP\Domain;

/**
 * Class Response
 */
class Response
{
    /**
     * @var string
     */
    protected $jsonDefinition;

    /**
     * @return string
     */
    public function getJsonDefinition()
    {
        return $this->jsonDefinition;
    }

    /**
     * @param string $jsonDefinition
     */
    public function setJsonDefinition($jsonDefinition)
    {
        $this->jsonDefinition = $jsonDefinition;
    }
}