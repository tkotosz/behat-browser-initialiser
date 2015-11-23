<?php

namespace Bex\Behat\BrowserInitialiserExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Bex\Behat\BrowserInitialiserExtension\ServiceContainer\Config;
use Bex\Behat\BrowserInitialiserExtension\ServiceContainer\ConfigValidator;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class BrowserInitialiserExtension implements Extension
{
    const CONFIG_KEY = 'browserinitialiser';

     /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return self::CONFIG_KEY;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // nothing to do here
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // nothing to do here
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $validator = new ConfigValidator();
        $builder
            ->children()
                ->booleanNode('close_browser_after_scanerio')
                    ->defaultFalse()
                ->end()
                ->scalarNode('browser_window_size')
                    ->defaultValue('max')
                    ->validate()
                        ->always($validator->getBrowserSizeValueValidator())
                    ->end()
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load('services.xml');

        $extensionConfig = new Config($config);
        $container->set('bex.browser_initialiser_extension.config', $extensionConfig);
    }
}