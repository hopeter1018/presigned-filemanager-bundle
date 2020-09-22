<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Controller;

use HoPeter1018\PresignedFilemanagerBundle\Services\Manager\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var ManagerRegistry */
    private $managerRegistry;

    public function __construct(EventDispatcherInterface $eventDispatcher, ManagerRegistry $managerRegistry)
    {
        // $this->eventDispatcher = $eventDispatcher;
        $this->managerRegistry = $managerRegistry;
    }

    public function indexAction(Request $request, string $manager)
    {
        return $this->render('HoPeter1018PresignedFilemanagerBundle:Default:index.html.twig');
    }

    public function getPresignedUrlAllowedParametersAction(Request $request, string $manager)
    {
        $manager = $this->getManager($manager);

        return $this->_getPresignedUrlAllowedParametersAction($manager, $request);
    }

    public function getPresignedUrlAction(Request $request, string $manager)
    {
        $manager = $this->getManager($manager);

        return $this->_getPresignedUrlAction($manager, $request);
    }

    public function postUploadedMetaAction(Request $request, string $manager)
    {
        $manager = $this->getManager($manager);

        return $this->_postUploadedMetaAction($manager, $request);
    }

    protected function _getPresignedUrlAllowedParametersAction(ManagerInterface $manager, Request $request)
    {
        $result = $manager->getAllowedParameters();

        return new JsonResponse($result);
    }

    protected function _getPresignedUrlAction(ManagerInterface $manager, Request $request)
    {
        $options = $service->sanitizePresign($request->isMethod('GET'), $request->request->all());
        $result = $service->presign($request->isMethod('GET'), $options);

        return new JsonResponse($result);
    }

    protected function _postUploadedMetaAction(ManagerInterface $manager, Request $request)
    {
        $options = $service->sanitizeUploaded($request->request->all());
        $result = $service->addRecord($options);

        return new JsonResponse([
          'id' => $result->getId(),
        ]);
    }

    protected function getManager(string $manager)
    {
        // $manager = $request->get('manager');
        $service = $this->managerRegistry->getByServiceId('ho_peter1018.presigned_filemanager.manager.'.$manager);
        if (null === $service) {
            throw new NotFoundHttpException("Manager `{$manager}` not found");
        } else {
            return $service;
        }
    }
}
