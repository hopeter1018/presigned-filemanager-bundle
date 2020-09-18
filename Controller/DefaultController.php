<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Controller;

use HoPeter1018\PresignedFilemanagerBundle\Events;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function indexAction(Request $request, string $manager)
    {
        return $this->render('HoPeter1018PresignedFilemanagerBundle:Default:index.html.twig');
    }

    public function getPresignedUrlAction(Request $request, string $manager)
    {
        dump(Events::BEFORE_PRESIGN);
        dump(Events::AFTER_PRESIGN);

        return new JsonResponse([]);
    }

    public function postUploadedMetaAction(Request $request, string $manager)
    {
        dump(Events::BEFORE_POST_UPLOAD);
        dump(Events::AFTER_POST_UPLOAD);

        return new JsonResponse([]);
    }
}
