<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\DependencyInjection;

use HoPeter1018\PresignedFilemanagerBundle\Entity\UploadedFile;
use HoPeter1018\PresignedFilemanagerBundle\Services\Manager\DefaultManager;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hopeter1018_presigned_filemanager');

        $rootNode
          ->children()
            ->arrayNode('signers')
              ->useAttributeAsKey('name')
              ->arrayPrototype()
                ->children()
                  ->scalarNode('service')->end()
                  ->scalarNode('signer')->end()
                  ->arrayNode('signer_argument')
                    ->scalarPrototype()->end()
                  ->end()
                ->end()
              ->end()
            ->end()
            ->arrayNode('managers')
              ->useAttributeAsKey('name')
              ->arrayPrototype()
                ->children()
                  ->scalarNode('service')->end()
                  ->scalarNode('manager')
                    ->defaultValue(DefaultManager::class)
                  ->end()
                  ->scalarNode('signer')
                    ->isRequired()
                    ->cannotBeEmpty()
                  ->end()
                  ->scalarNode('entity_class')->defaultValue(UploadedFile::class)->end()
                  ->scalarNode('connection')->defaultValue('default')->end()
                  ->append($this->addAllowedGetParameters())
                  ->append($this->addAllowedPostParameters())
                  ->arrayNode('manager_argument')
                    ->scalarPrototype()->end()
                  ->end()
                ->end()
              ->end()
            ->end()
          ->end()
        ;

        return $treeBuilder;
    }

    public function addAllowedGetParameters()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('allowed_get_parameters');

        $node
            ->ignoreExtraKeys()
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('expires')->defaultValue(true)->end()
                ->scalarNode('filename')->defaultValue(true)->end()
            ->end()
        ;

        return $node;
    }

    public function addAllowedPostParameters()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('allowed_post_parameters');

        $node
            ->ignoreExtraKeys()
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('uploadPathPrefix')->defaultValue(true)->end()
                ->scalarNode('contentTypePrefix')->defaultValue(true)->end()
                ->scalarNode('public')->defaultValue(false)->end()
                ->scalarNode('gz')->defaultValue(false)->end()
                ->scalarNode('expires')->defaultValue(false)->end()
                ->scalarNode('sizeMin')->defaultValue(true)->end()
                ->scalarNode('sizeMax')->defaultValue(false)->end()
                ->scalarNode('filename')->defaultValue(true)->end()
            ->end()
        ;

        return $node;
    }
}
