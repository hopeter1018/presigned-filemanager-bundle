<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ManagerByRequestController extends DefaultController
{
    public function getManagerPresignedUrlAllowedParametersAction(Request $request)
    {
        $manager = $this->getManagerByRequest($request);

        return $this->_getPresignedUrlAllowedParametersAction($manager, $request);
    }

    public function getManagerPresignedUrlAction(Request $request)
    {
        $manager = $this->getManagerByRequest($request);

        return $this->_getPresignedUrlAction($manager, $request);
    }

    public function postManagerUploadedMetaAction(Request $request)
    {
        $manager = $this->getManagerByRequest($request);

        return $this->_postUploadedMetaAction($manager, $request);
    }

    protected function getManagerByRequest(Request $request)
    {
        $manager = $request->query->has('manager') ? $request->query->get('manager') : $request->request->get('manager');
        $service = $this->managerRegistry->getByServiceId('ho_peter1018.presigned_filemanager.manager.'.$manager);
        if (null === $service) {
            throw new NotFoundHttpException("Manager `{$manager}` not found");
        } else {
            return $service;
        }
    }
}
