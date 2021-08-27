<?php

namespace Intaro\PostgresSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder('intaro_postgres_search');

        if (!method_exists($tree, 'getRootNode')) {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $tree->root('intaro_postgres_search')
                ->end()
            ;
        }

        return $tree;
    }
}
