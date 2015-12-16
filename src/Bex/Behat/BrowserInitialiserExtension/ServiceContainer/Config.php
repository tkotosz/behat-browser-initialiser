<?php

namespace Bex\Behat\BrowserInitialiserExtension\ServiceContainer;

class Config
{
    const CONFIG_KEY_CLOSE_BROWSER = 'close_browser_after_scenario';
    const CONFIG_KEY_WINDOWS_SIZE = 'browser_window_size';

    /**
     * @var boolean
     */
    private $closeBrowser;

    /**
     * @var string
     */
    private $windowSize;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->closeBrowser = $config[self::CONFIG_KEY_CLOSE_BROWSER];
        $this->windowSize = $config[self::CONFIG_KEY_WINDOWS_SIZE];
    }

    /**
     * @return boolean
     */
    public function shouldCloseBrowser()
    {
        return $this->closeBrowser;
    }

    /**
     * @return boolean
     */
    public function shouldMaximizeWindow()
    {
        return $this->windowSize == 'max';
    }

    /**
     * @return int
     */
    public function getWindowWidth()
    {
        $sizes = explode('x', $this->windowSize);
        return $sizes[0];
    }

    /**
     * @return int
     */
    public function getWindowHeight()
    {
        $sizes = explode('x', $this->windowSize);
        return $sizes[1];
    }
}