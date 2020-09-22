<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Manager;

use Doctrine\ORM\EntityManagerInterface;
use HoPeter1018\PresignedFilemanagerBundle\Services\Signer\SignerInterface;
use Symfony\Component\EventDispatcher\Event;

class AbstractManager
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

    /** @var ManagerHelper */
    private $managerHelper;

    /** @var SignerInterface */
    protected $signer;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var string */
    protected $connection;

    /** @var string */
    protected $entityFqcn;

    /** @var array */
    protected $allowedGetParameters;

    /** @var array */
    protected $allowedPostParameters;

    public function __construct(ManagerHelper $managerHelper, SignerInterface $signer, EntityManagerInterface $em, string $connection, string $entityFqcn, array $allowedGetParameters, array $allowedPostParameters)
    {
        $this->managerHelper = $managerHelper;
        $this->signer = $signer;
        $this->em = $em;
        $this->connection = $connection;
        $this->entityFqcn = $entityFqcn;
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

    public function eventDispatch(Event $event)
    {
        return $this->managerHelper->getEventDispatcher()->dispatch($event::NAME, $event);
    }

    public function getEventDispatcher()
    {
        return $this->managerHelper->getEventDispatcher();
    }

    public function getPropertyAccessor()
    {
        return $this->managerHelper->getPropertyAccessor();
    }

    public function isPropWritable($obj, $name)
    {
        return $this->getPropertyAccessor()->isWritable($obj, $name);
    }

    public function setProp($obj, $name, $value)
    {
        if ($this->isPropWritable($obj, $name)) {
            return $this->getPropertyAccessor()->setValue($obj, $name, $value);
        } else {
            return null;
        }
    }

    public function getProp($obj, $name)
    {
        return $this->getPropertyAccessor()->getValue($obj, $name);
    }

    public function devPrint()
    {
        return [
          $this->entityFqcn,
          $this->connection,
        ];
    }
}
