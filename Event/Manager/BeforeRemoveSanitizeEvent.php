<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Event\Manager;

use HoPeter1018\PresignedFilemanagerBundle\Events;
use Symfony\Component\EventDispatcher\Event;

class BeforeRemoveSanitizeEvent extends Event
{
    const NAME = Events::MANAGER_BEFORE_REMOVE_SANITIZE;

    public function __construct(array $options)
    {
    }
}
