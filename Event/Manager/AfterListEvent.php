<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Event\Manager;

use HoPeter1018\PresignedFilemanagerBundle\Events;
use Symfony\Component\EventDispatcher\Event;

class AfterListEvent extends Event
{
    const NAME = Events::MANAGER_AFTER_LIST;

    public function __construct(array $options)
    {
    }
}
