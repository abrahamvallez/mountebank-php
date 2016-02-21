<?php

namespace MountebankPHP\Domain;

/**
 * Class Stub
 */
class Stub
{
    /**
     * @var array
     */
    protected $responses;

    /**
     * @var array
     */
    protected $predicates;

    /**
     * @return array
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @param Response $response
     */
    public function addResponse(Response $response)
    {
        $this->responses[] = $response;
    }

    /**
     * @return array
     */
    public function getPredicates()
    {
        return $this->predicates;
    }

    /**
     * @param Predicate $predicate
     */
    public function addPredicate(Predicate $predicate)
    {
        $this->predicates[] = $predicate;
    }
}