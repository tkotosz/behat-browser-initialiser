Behat-BrowserInitialiserExtension
=========================

Behat-BrowserInitialiserExtension helps configure the browser for behat scenarios.

Installation
------------

Install by adding to your `composer.json`:

```bash
composer require --dev bex/behat-browser-initialiser
```

Configuration
-------------

Enable the extension in `behat.yml` like this:

```yml
default:
  extensions:
    Bex\Behat\BrowserInitialiserExtension: ~
```

You can configure to close the browser after each scenario:
```yml
default:
  extensions:
    Bex\Behat\BrowserInitialiserExtension:
      close_browser_after_scenario: true
```

You can configure to broser size like this:
```yml
default:
  extensions:
    Bex\Behat\BrowserInitialiserExtension:
      browser_window_size: 1024x768
```

Or maximize the browser window like this:
```yml
default:
  extensions:
    Bex\Behat\BrowserInitialiserExtension:
      browser_window_size: max
```

Usage
-----

When you run behat the extension will configure the browser size automatically.