<?php

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\DependencyInjection\Services;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * SignerProviderPass
 * Generated: 2020-09-16T04:03:15+00:00.
 */
class SignerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has('ho_peter1018.presigned_filemanager.services.signer_registry')) {
            return;
        }
        $definition = $container->findDefinition('ho_peter1018.presigned_filemanager.services.signer_registry');

        // find all service IDs with the ho_peter1018.presigned_filemanager.services.signer_pool tag
        $taggedServices = $container->findTaggedServiceIds('ho_peter1018.presigned_filemanager.services.signer_pool');

        foreach ($taggedServices as $id => $tags) {
            // add the service to the registry service
            $definition->addMethodCall('add', [$id, new Reference($id), $tags]);
        }
    }
}
