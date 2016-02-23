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
     *
     * @return $this
     */
    public function addResponse(Response $response)
    {
        $this->responses[] = $response;

        return $this;
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
     *
     * @return $this
     */
    public function addPredicate(Predicate $predicate)
    {
        $this->predicates[] = $predicate;

        return $this;
    }
}