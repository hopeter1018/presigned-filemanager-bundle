<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\DependencyInjection;

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
                  ->scalarNode('entity_class')
                    ->defaultValue('HoPeter1018\PresignedFilemanagerBundle\Entity\UploadedFile')
                  ->end()
                  ->scalarNode('signer')
                    ->isRequired()
                    ->cannotBeEmpty()
                  ->end()
                ->end()
              ->end()
            ->end()
          ->end()
        ;

        return $treeBuilder;
    }
}
