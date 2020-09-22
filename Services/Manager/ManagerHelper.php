<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class ManagerHelper
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var PropertyAccessorInterface */
    private $propertyAccessor;

    public function __construct(EventDispatcherInterface $eventDispatcher, PropertyAccessorInterface $propertyAccessor)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * Get the value of Event Dispatcher.
     *
     * @return mixed
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * Get the value of Property Accessor.
     *
     * @return mixed
     */
    public function getPropertyAccessor()
    {
        return $this->propertyAccessor;
    }
}
