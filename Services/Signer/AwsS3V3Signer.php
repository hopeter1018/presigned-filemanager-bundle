<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Services\Signer;

use Aws\S3\PostObjectV4;
use Aws\S3\S3Client;

class AwsS3V3Signer implements SignerInterface
{
    protected $client;
    protected $bucket;

    public function __construct(S3Client $client, string $bucket)
    {
        $this->client = $client;
        $this->bucket = $bucket;
    }
    
    protected function sanitizeOptions(array $options): array
    {
        $options['bucket'] = isset($options['bucket']) ? $options['bucket'] : $this->bucket;
        $options['uploadPathPrefix'] = isset($options['uploadPathPrefix']) ? $options['uploadPathPrefix'] : '';
        $options['contentTypePrefix'] = isset($options['contentTypePrefix']) ? $options['contentTypePrefix'] : '';
        $options['public'] = isset($options['public']) ? $options['public'] : false;
        $options['gz'] = isset($options['gz']) ? $options['gz'] : false;
        $options['expires'] = isset($options['expires']) ? $options['expires'] : '+1 hour';
        $options['sizeMin'] = isset($options['sizeMin']) ? $options['sizeMin'] : 1;
        $options['sizeMax'] = isset($options['sizeMax']) ? $options['sizeMax'] : 5242880;
        $options['filename'] = isset($options['filename']) ? $options['filename'] : '';

        return $options;
    }

    public function signGet(array $options)
    {
        $options = $this->sanitizeOptions($options);
        extract($options);
        
        $cmd = $this->client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => $filename,
        ]);

        $request = $client->createPresignedRequest($cmd, $expires);

        return (string) $request->getUri();
    }
    
    public function signPost(array $options) {
        $options = $this->sanitizeOptions($options);
        extract($options);

        $formInputs = [];
        $options = [
            ['bucket' => $bucket],
            ['starts-with', '$key', $uploadPathPrefix],
            ['starts-with', '$content-type', $contentTypePrefix],
            ['starts-with', '$x-amz-meta-original-size', ''],
            ['content-length-range', $sizeMin, $sizeMax],
        ];

        if ($public) {
            $formInputs['acl'] = 'public-read';
            $options[] = ['acl' => 'public-read'];
        }

        if ($gz) {
            $options[] = ['eq', '$content-encoding', 'gzip'];
        }

        $expires = '+1 hour';
        $postObject = new PostObjectV4($this->client, $bucket, $formInputs, $options, $expires);

        $formAttributes = $postObject->getFormAttributes();

        $formInputs = $postObject->getFormInputs();

        return [
            'formAttributes' => $formAttributes,
            'formInputs' => $formInputs,
            'folderName' => $uploadPathPrefix,
        ];
    }

    public function validateSignPost(array $options) {
      
    }
}
