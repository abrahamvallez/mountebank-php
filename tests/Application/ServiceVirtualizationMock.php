<?php

namespace MountebankPHP\Tests\Application;

use MountebankPHP\Application\ServiceVirtualization;
use MountebankPHP\Domain\ImposterFormatter;

/**
 * Class ServiceVirtualizationMock
 */
class ServiceVirtualizationMock extends ServiceVirtualization
{
    /**
     * @param ImposterFormatter $imposterFormatter
     *
     * @return $this
     */
    public function setImposterFormatter($imposterFormatter)
    {
        $this->imposterFormatter = $imposterFormatter;

        return $this;
    }
}