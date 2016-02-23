<?php

namespace MountebankPHP\Domain;

/**
 * Class Predicate
 */
class Predicate
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
     *
     * @return $this
     */
    public function setJsonDefinition($jsonDefinition)
    {
        $this->jsonDefinition = $jsonDefinition;

        return $this;
    }
}