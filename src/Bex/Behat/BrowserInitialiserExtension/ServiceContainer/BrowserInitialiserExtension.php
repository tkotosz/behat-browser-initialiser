<?php

namespace Bex\Behat\BrowserInitialiserExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Bex\Behat\BrowserInitialiserExtension\ServiceContainer\Config;
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
        $builder
            ->children()
                ->booleanNode('close_browser_after_scanerio')
                    ->defaultFalse()
                ->end()
                ->scalarNode('browser_window_size')
                    ->defaultValue('max')
                    ->validate()
                        ->always($this->getBrowserSizeValueValidator())
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

    /**
     * @return \Closure
     */
    private function getBrowserSizeValueValidator()
    {
        return function ($value) {
            $size = explode('x', $value);
            $width = isset($size[0]) ? $size[0] : '';
            $height = isset($size[1]) ? $size[1] : '';

            if ($value == 'max' || (is_numeric($width) && is_numeric($height))) {
                return $value;
            }

            throw new \InvalidArgumentException("Invalid browser size: $value. Valid values: 'max' or 'WIDTHxHEIGHT");
        };
    }
}