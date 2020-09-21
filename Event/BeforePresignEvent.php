<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Event;

use HoPeter1018\PresignedFilemanagerBundle\Events;
use Symfony\Component\EventDispatcher\Event;

class BeforePresignEvent extends Event
{
    const NAME = Events::BEFORE_PRESIGN_SANITIZE;

    public function __construct(bool $isGet, array $options)
    {
    }
}
