<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Manager;

use HoPeter1018\PresignedFilemanagerBundle\Event\Manager as Event;

class NullManager extends AbstractManager implements ManagerInterface
{
    public function sanitizeList(array $options)
    {
        $this->eventDispatch(new Event\BeforeListSanitizeEvent($options));

        $result = [];

        $this->eventDispatch(new Event\AfterListSanitizeEvent($options, $result));

        return $result;
    }

    public function list(array $options)
    {
        $this->eventDispatch(new Event\BeforeListEvent($options));

        $result = [];

        $this->eventDispatch(new Event\AfterListEvent($options, $result));

        return $result;
    }

    public function sanitizeRemove(array $options)
    {
        $this->eventDispatch(new Event\BeforeRemoveSanitizeEvent($options));

        $result = [];

        $this->eventDispatch(new Event\AfterRemoveSanitizeEvent($options, $result));

        return $result;
    }

    public function remove(array $options)
    {
        $this->eventDispatch(new Event\BeforeRemoveEvent($options));

        $result = [];

        $this->eventDispatch(new Event\AfterRemoveEvent($options, $result));

        return $result;
    }

    public function sanitizePresign(bool $isGet, array $options)
    {
        $this->eventDispatch(new Event\BeforePresignSanitizeEvent($isGet, $options));

        $result = [];

        $this->eventDispatch(new Event\AfterPresignSanitizeEvent($isGet, $options, $result));

        return $result;
    }

    public function presign(bool $isGet, array $options)
    {
        $this->eventDispatch(new Event\BeforePresignEvent($isGet, $options));

        $result = $isGet ? $this->signer->signGet($options) : $this->signer->signPost($options);

        $this->eventDispatch(new Event\AfterPresignEvent($isGet, $options, $result));

        return $result;
    }

    public function sanitizeUploaded(array $options)
    {
        $this->eventDispatch(new Event\BeforeUploadedSanitizeEvent($options));

        $result = [];

        $this->eventDispatch(new Event\AfterUploadedSanitizeEvent($options, $result));

        return $result;
    }

    public function uploaded(array $options)
    {
        $this->eventDispatch(new Event\BeforeUploadedEvent($options));

        $result = [];

        $this->eventDispatch(new Event\AfterUploadedEvent($options, $result));

        return $result;
    }
}
