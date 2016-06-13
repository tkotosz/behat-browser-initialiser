<?php

namespace Bex\Behat\BrowserInitialiserExtension\Listener;

use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Bex\Behat\BrowserInitialiserExtension\Service\BrowserWindowHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class BrowserInitialiserListener implements EventSubscriberInterface
{
    /**
     * @var BrowserWindowHandler
     */
    private $browserWindowHandler;

    /**
     * @param BrowserWindowHandler $browserWindowHandler
     */
    public function __construct(BrowserWindowHandler $browserWindowHandler)
    {
        $this->browserWindowHandler = $browserWindowHandler;
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
        $this->browserWindowHandler->initBrowserWindow();
    }

    public function closeBrowserWindow()
    {
        $this->browserWindowHandler->closeBrowserWindow();
    }
}