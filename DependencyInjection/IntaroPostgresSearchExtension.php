<?php

namespace Oi\PostgresSearchBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class IntaroPostgresSearchExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $config = [
            'dbal' => [
                'types' => [
                    'tsvector' => [
                        'class' => 'Oi\PostgresSearchBundle\DBAL\TsvectorType',
                        'commented' => false,
                    ],
                    'tsvector_simple' => [
                        'class' => 'Oi\PostgresSearchBundle\DBAL\TsvectorSimpleType',
                        'commented' => false,
                    ],
                ],
                'mapping_types' => [
                    'tsvector' => 'tsvector',
                    'tsvector_simple' => 'tsvector',
                ],
            ],
            'orm' => [
                'dql' => [
                    'string_functions' => [
                        'tsquery' => 'Oi\PostgresSearchBundle\DQL\TsqueryFunction',
                        'plainto_tsquery' => 'Oi\PostgresSearchBundle\DQL\PlainToTsqueryFunction',
                        'tsrank' => 'Oi\PostgresSearchBundle\DQL\TsrankFunction',
                        'tsheadline' => 'Oi\PostgresSearchBundle\DQL\TsheadlineFunction',
                    ],
                ],
            ],
        ];

        $container->prependExtensionConfig('doctrine', $config);
    }
}
