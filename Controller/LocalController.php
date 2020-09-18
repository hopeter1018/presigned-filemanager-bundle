<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LocalController extends Controller
{
    public function postUploadAction(Request $request, string $manager)
    {
        return new Response('', 204);
        // return new JsonResponse([]);
    }

    public function bucketPresignedPostAction(Request $request)
    {
        $options = $request->request->get('options');
        $uploadPathPrefix = $request->request->get('uploadPathPrefix');
        $hash = $request->request->get('hash');

        if ($hash === sha1($uploadPathPrefix.$options.$this->getBucketName())) {
            $key = $request->request->get('key');
            $optionsMap = json_decode($options);

            // TODO validate and execute $options

            /** @var UploadedFile */
            $file = $request->files->get('file');

            dump($key);
            dump($key);
            $fullpath = $this->getPath().'/'.str_replace('${filename}', $file->getClientOriginalName(), $key);
            $file->move(dirname($fullpath), basename($fullpath));
        }

        return new Response('', 204);
    }

    public function bucketPresignedAction(Request $request, $path)
    {
        // $serviceId = $request->request->get('__');
        // /** @var FileSystemProviderInterface */
        // $fileSystemProvider = $fileSystemProviderRegistry->getByServiceId($serviceId);
        // dump(getcwd().base64_decode($path));
        // $fileSystemProvider->handleDevPresignedPost($request);
        $exactFile = (getcwd().'/..'.base64_decode($path));

        $response = new StreamedResponse();
        $response->setCallback(function () use ($exactFile) {
            $fp = fopen($exactFile, 'rb');
            fpassthru($fp);
        });

        $response->headers->set('Content-Type', \GuzzleHttp\Psr7\mimetype_from_filename($exactFile));
        $response->headers->set('Content-length', filesize($exactFile));
        $response->headers->set('Connection', 'Keep-Alive');
        $response->headers->set('Accept-Ranges', 'bytes');
        $response->send();
    }
}
