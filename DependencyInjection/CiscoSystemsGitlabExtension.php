<?php

namespace CiscoSystems\GitlabBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\DependencyInjection\ContainerBuilder;

class CiscoSystemsGitlabExtension extends Extension
{
    public function load( array $configs, ContainerBuilder $container )
    {
        // Merge data from configuration files, extending files override
        $config = array();
        foreach ( $configs as $subConfig ) $config = array_merge( $config, $subConfig );
        // Load bundle default configuration
        $loader = new YamlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config' ) );
        $loader->load( 'services.yml' );
        // Set parameters
        if ( isset( $config['client_class'] ) )
        {
            $container->setParameter( 'gitlab.client.class', $config['client_class'] );
        }
    }
}
