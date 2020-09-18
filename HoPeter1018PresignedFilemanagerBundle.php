<?php

namespace HoPeter1018\PresignedFilemanagerBundle;

use HoPeter1018\PresignedFilemanagerBundle\DependencyInjection\Services\ManagerPass;
use HoPeter1018\PresignedFilemanagerBundle\DependencyInjection\Services\SignerPass;
use HoPeter1018\PresignedFilemanagerBundle\Services\Manager\ManagerInterface;
use HoPeter1018\PresignedFilemanagerBundle\Services\Signer\SignerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HoPeter1018PresignedFilemanagerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ManagerPass());
        $container->registerForAutoconfiguration(ManagerInterface::class)->addTag('ho_peter1018.presigned_filemanager.services.manager_pool');
        $container->addCompilerPass(new SignerPass());
        $container->registerForAutoconfiguration(SignerInterface::class)->addTag('ho_peter1018.presigned_filemanager.services.signer_pool');
    }
}
