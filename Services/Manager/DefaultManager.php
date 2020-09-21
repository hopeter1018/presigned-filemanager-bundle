<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use HoPeter1018\PresignedFilemanagerBundle\Event\BeforePresignEvent;
use HoPeter1018\PresignedFilemanagerBundle\Events;
use HoPeter1018\PresignedFilemanagerBundle\Services\Signer\SignerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DefaultManager implements ManagerInterface
{
    const ALLOWED_GET_PARAMETERS = [
        'action',
        'expires',
        'filename',
    ];

    const ALLOWED_POST_PARAMETERS = [
        'uploadPathPrefix',
        'contentTypePrefix',
        'public',
        'gz',
        'expires',
        'sizeMin',
        'sizeMax',
        'filename',
    ];

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var SignerInterface */
    protected $signer;

    /** @var ManagerRegistry */
    protected $managerRegistry;

    /** @var EntityManagerInterface */
    protected $em;

    protected $connection;
    protected $entityFqcn;
    protected $allowedGetParameters;
    protected $allowedPostParameters;

    public function __construct(EventDispatcherInterface $eventDispatcher, SignerInterface $signer, ManagerRegistry $managerRegistry, EntityManagerInterface $em, string $connection, string $entityFqcn, array $allowedGetParameters, array $allowedPostParameters)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->managerRegistry = $managerRegistry;
        $this->connection = $connection;
        $this->em = $em;
        $this->entityFqcn = $entityFqcn;
        $this->signer = $signer;
        $this->allowedGetParameters = $allowedGetParameters;
        $this->allowedPostParameters = $allowedPostParameters;
    }

    public function getAllowedParameters()
    {
        return [
          'GET' => $this->allowedGetParameters,
          'POST' => $this->allowedPostParameters,
        ];
    }

    public function sanitizePresign(bool $isGet, array $options)
    {
        $result = [];

        $this->eventDispatcher->dispatch(Events::BEFORE_PRESIGN_SANITIZE, new BeforePresignEvent($isGet, $options));

        $allowedList = $isGet ? $this->allowedGetParameters : $this->allowedPostParameters;
        foreach ($allowedList as $key => $isAllow) {
            if ($isAllow and isset($options[$key])) {
                $result[$key] = $options[$key];
            }
        }

        return $result;
    }

    public function presign(bool $isGet, array $options)
    {
        return $isGet ? $this->signer->signGet($options) : $this->signer->signPost($options);
    }

    public function sanitizeUploaded(array $options)
    {
    }

    public function addRecord(array $options)
    {
    }

    public function count()
    {
        return $this->em->getRepository($this->entityFqcn)->count([]);
    }

    public function devPrint()
    {
        return [
          $this->entityFqcn,
          $this->connection,
        ];
    }
}
