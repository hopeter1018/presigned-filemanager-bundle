<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Signer;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LocalSigner implements SignerInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router, string $dest)
    {
        $this->router = $router;
        $this->dest = $dest;
    }

    public function signGet(array $options)
    {
        $options = $this->sanitizeOptions($options);
        $hash = $this->hash();
        $url = $this->router->generate('hopeter1018_presigned_filemanager_local_get', [
          'hash' => $hash,
        ]);

        return 'https:'.$url;
    }

    public function signPost(array $options)
    {
        $options = $this->sanitizeOptions($options);
        $hash = $this->hash();
        $url = $this->router->generate('hopeter1018_presigned_filemanager_local_post_upload', []);

        return [
          'formAttributes' => [
            'action' => 'https:'.$url,
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
          ],
          'formInputs' => [
            'hash' => $hash,
          ],
        ];
    }

    protected function sanitizeOptions(array $options): array
    {
        return $options;
    }

    protected function hash()
    {
        return hash('sha256', '');
    }
}
