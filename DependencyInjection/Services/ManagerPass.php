<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\DependencyInjection\Services;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ManagerPass
 * Generated: 2020-09-18T02:33:59+00:00.
 */
class ManagerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has('ho_peter1018.presigned_filemanager.services.manager_registry')) {
            return;
        }
        $definition = $container->findDefinition('ho_peter1018.presigned_filemanager.services.manager_registry');

        // find all service IDs with the ho_peter1018.presigned_filemanager.services.manager_pool tag
        $taggedServices = $container->findTaggedServiceIds('ho_peter1018.presigned_filemanager.services.manager_pool');

        foreach ($taggedServices as $id => $tags) {
            // add the service to the registry service
            $definition->addMethodCall('add', [$id, new Reference($id), $tags]);
        }
    }
}
