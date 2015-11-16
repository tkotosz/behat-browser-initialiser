<?php

namespace Bex\Behat\BrowserInitialiserExtension\Listener;

use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Behat\Mink\Mink;
use Bex\Behat\BrowserInitialiserExtension\ServiceContainer\Config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class BrowserInitialiserListener implements EventSubscriberInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Mink
     */
    private $mink;

    /**
     * @param Config $config
     * @param Mink   $mink
     */
    public function __construct(Config $config, Mink $mink)
    {
        $this->config = $config;
        $this->mink = $mink;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ScenarioTested::BEFORE => 'initBrowserWindow',
            ScenarioTested::AFTER => 'closeBrowserWindow'
        ];
    }

    public function initBrowserWindow()
    {
        if ($this->config->shouldMaximizeWindow()) {
            $this->mink->getSession()->maximizeWindow();
        } else {
            $this->mink->getSession()->resizeWindow(
                $this->config->getWindowWidth(),
                $this->config->getWindowHeight()
            );
        }
    }

    public function closeBrowserWindow()
    {
        if ($this->config->shouldCloseBrowser()) {
            $this->mink->getSession()->stop();
        }
    }
}