<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Signer;

/**
 * SignerInterface
 * Generated: 2020-09-16T04:03:15+00:00.
 */
interface SignerInterface
{
    public function signGet(array $options);

    public function signPost(array $options);
}
