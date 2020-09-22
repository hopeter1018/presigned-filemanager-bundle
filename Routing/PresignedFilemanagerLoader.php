<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class PresignedFilemanagerLoader extends Loader
{
    private $usedPrefixes = [];

    public function load($resource, $type = null)
    {
        // if (true === $this->isLoaded) {
        //     throw new \RuntimeException('Do not add the "extra" loader twice');
        // }

        if ('.' === $resource) {
            $parsed = [
              'name_prefix' => '',
              'mode' => 'default',
            ];
        } else {
            parse_str($resource, $parsed);
            parse_str($resource, $parsedForValidate);
            if (isset($parsedForValidate['_'])) {
                $parsed = [
                  'name_prefix' => '',
                  'mode' => 'default',
                ];
            } else {
                if (isset($parsedForValidate['name_prefix'])) {
                    unset($parsedForValidate['name_prefix']);
                } else {
                    $parsed['name_prefix'] = '';
                }
                if (isset($parsedForValidate['mode'])) {
                    unset($parsedForValidate['mode']);
                } else {
                    $parsed['mode'] = 'default';
                }
                if (0 !== count($parsedForValidate)) {
                    throw new \Exception('Unknown resource key ('.implode(', ', array_keys($parsedForValidate)).')');
                }
            }
        }

        if (in_array($parsed['name_prefix'], $this->usedPrefixes)) {
            throw new \Exception('Duplicated name_prefix ('.$parsed['name_prefix'].')');
        }

        $routes = new RouteCollection();

        $importPath = ('multi' === $parsed['mode']) ? '@HoPeter1018PresignedFilemanagerBundle/Resources/config/routing_manager_by_request.yml' : '@HoPeter1018PresignedFilemanagerBundle/Resources/config/routing.yml';
        $importedRoutes = $this->import($importPath, 'yaml');
        foreach ($importedRoutes->getIterator() as $name => $importedRoute) {
            $routes->add($parsed['name_prefix'].$name, $importedRoute);
        }

        $this->usedPrefixes[] = $parsed['name_prefix'];

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'presigned_filemanager' === $type;
    }
}
