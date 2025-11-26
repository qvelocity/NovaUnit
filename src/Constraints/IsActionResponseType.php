<?php

namespace JoshGaber\NovaUnit\Constraints;

use PHPUnit\Framework\Constraint\Constraint;

class IsActionResponseType extends Constraint
{
    private $actionResponse;
    private $actionType;

    public function __construct($actionType, $actionResponse)
    {
        $this->actionResponse = $actionResponse;
        $this->actionType = $actionType;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return \sprintf('matches the "%s" Action response', $this->actionType);
    }

    public function matches($response): bool
    {
        return $this->actionResponse->offsetExists($this->actionType);
    }
}
