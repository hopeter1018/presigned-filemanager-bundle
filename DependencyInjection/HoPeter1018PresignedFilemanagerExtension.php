<?php

namespace HoPeter1018\PresignedFilemanagerBundle\DependencyInjection;

use Doctrine\Common\Persistence\ManagerRegistry;
use HoPeter1018\PresignedFilemanagerBundle\Services\Manager\ManagerInterface;
use HoPeter1018\PresignedFilemanagerBundle\Services\Signer\SignerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class HoPeter1018PresignedFilemanagerExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        // determine if AcmeGoodbyeBundle is registered
        // if (!isset($bundles['AcmeGoodbyeBundle'])) {
            // disable AcmeGoodbyeBundle in bundles
            // $config = ['use_acme_goodbye' => false];
            // foreach ($container->getExtensions() as $name => $extension) {
            //     switch ($name) {
            //         case 'acme_something':
            //         case 'acme_other':
            //             // set use_acme_goodbye to false in the config of
            //             // acme_something and acme_other
            //             //
            //             // note that if the user manually configured
            //             // use_acme_goodbye to true in config/services.yaml
            //             // then the setting would in the end be true and not false
            //             $container->prependExtensionConfig($name, $config);
            //             break;
            //     }
            // }
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services/services.signer.xml');
        $loader->load('services/services.manager.xml');

        $parameters = $container->getParameterBag()->all();
        $signerMap = [];
        foreach ($parameters as $name => $value) {
            if (strstr($name, 'ho_peter1018.presigned_filemanager.signer')) {
                $class = new \ReflectionClass($value);
                if ($class->implementsInterface(SignerInterface::class)) {
                    $signerMap[$name] = $value;
                } else {
                    throw new \Exception("Parameter {$name} must be a valid php class implementing interface `SignerInterface`");
                }
            }
            if (strstr($name, 'ho_peter1018.presigned_filemanager.manager')) {
                $class = new \ReflectionClass($value);
                if ($class->implementsInterface(ManagerInterface::class)) {
                    $signerMap[$name] = $value;
                } else {
                    throw new \Exception("Parameter {$name} must be a valid php class implementing interface `ManagerInterface`");
                }
            }
        }

        foreach ($config['signers'] as $key => $signer) {
            if (isset($signer['service'])) {
                $container->setAlias("ho_peter1018.presigned_filemanager.signer.{$key}", substr($signer['service'], 1));
            } else {
                $signerClass = class_exists($signer['signer']) ? $signer['signer'] : $container->getParameter('ho_peter1018.presigned_filemanager.signer.'.$signer['signer']);
                $definition = $container->register("ho_peter1018.presigned_filemanager.signer.{$key}", $signerClass)
                  ->addTag('ho_peter1018.presigned_filemanager.services.signer_pool');

                if ($signer['signer_argument']) {
                    foreach ($signer['signer_argument'] as $argument) {
                        $this->addDefinitionArgument($container, $definition, $argument);
                    }
                }
            }
        }

        foreach ($config['managers'] as $key => $manager) {
            if (isset($manager['service'])) {
                $container->setAlias("ho_peter1018.presigned_filemanager.manager.{$key}", substr($manager['service'], 1));
            } else {
                $managerClass = class_exists($manager['manager']) ? $manager['manager'] : $container->getParameter('ho_peter1018.presigned_filemanager.manager.'.$manager['manager']);
                $definition = $container->register("ho_peter1018.presigned_filemanager.manager.{$key}", $managerClass)
                  ->addTag('ho_peter1018.presigned_filemanager.services.manager_pool');

                $this->addDefinitionArgument($container, $definition, new Reference(EventDispatcherInterface::class));
                $this->addDefinitionArgument($container, $definition, new Reference('ho_peter1018.presigned_filemanager.signer.'.$manager['signer']));
                $this->addDefinitionArgument($container, $definition, new Reference(ManagerRegistry::class));
                $this->addDefinitionArgument($container, $definition, new Reference('doctrine.orm.'.$manager['connection'].'_entity_manager'));
                $this->addDefinitionArgument($container, $definition, $manager['connection']);
                $this->addDefinitionArgument($container, $definition, $manager['entity_class']);
                $this->addDefinitionArgument($container, $definition, $manager['allowed_get_parameters']);
                $this->addDefinitionArgument($container, $definition, $manager['allowed_post_parameters']);

                if ($manager['manager_argument']) {
                    foreach ($manager['manager_argument'] as $name => $argument) {
                        $this->addDefinitionArgument($container, $definition, $argument);
                    }
                }
            }
        }
    }

    protected function addDefinitionArgument($container, &$definition, $argument)
    {
        if (is_array($argument)) {
            $definition->addArgument($argument);
        } elseif (strstr($argument, '@')) {
            $definition->addArgument(new Reference(substr($argument, 1)));
        } elseif ('%' === substr($argument, 0, 1) and '%' === substr($argument, -1)) {
            $definition->addArgument($container->getParameter(substr($argument, 1, -1)));
        } else {
            $definition->addArgument($argument);
        }
    }
}
