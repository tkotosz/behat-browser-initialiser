<?php

namespace Bex\Behat\BrowserInitialiserExtension\Service;

use Behat\Mink\Mink;
use Bex\Behat\BrowserInitialiserExtension\ServiceContainer\Config;
use Symfony\Component\Console\Output\OutputInterface;

class BrowserWindowHandler
{
    /**
     * @var Mink
     */
    private $mink;
    
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var Config $config
     */
    private $config;

    /**
     * @param Mink            $mink
     * @param OutputInterface $output
     * @param Config          $config
     */
    public function __construct(Mink $mink, OutputInterface $output, Config $config)
    {
        $this->mink = $mink;
        $this->output = $output;
        $this->config = $config;
    }

    public function initBrowserWindow()
    {
        if ($this->config->shouldMaximizeWindow()) {
            $this->maximizeWindow();
        } else {
            $this->resizeWindow($this->config->getWindowWidth(), $this->config->getWindowHeight());
        }
    }

    public function closeBrowserWindow()
    {
        if ($this->config->shouldCloseBrowser()) {
            $this->closeWindow();
        }
    }

    private function maximizeWindow()
    {
        try {
            $this->mink->getSession()->maximizeWindow();
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
        }  
    }

    private function resizeWindow($width, $height)
    {
        try {
            $this->mink->getSession()->resizeWindow($width, $height);
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
        }  
    }

    private function closeWindow()
    {
        try {
            $this->mink->getSession()->stop();
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
        }  
    }
}