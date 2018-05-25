Feature: Taking screenshot
  In order to debug failing scenarios more easily
  As a developer
  I should see a screenshot of the browser window of the failing step

  Background:
    Given I have the file "index.html" in document root:
      """
      <!DOCTYPE html>
      <html>
          <head>
              <meta charset="UTF-8">
              <title>Test page</title>
              <style>
                  body {background-color: #a9a9a9;}
              </style>
          </head>

          <body>
              <h1>Lorem ipsum dolor amet.</h1>
          </body>
          <script>
          document.write("<span>Is full screen?: " + ((window.innerHeight == screen.height) ? "YES" : "NO") + "</span>");
          document.write("<span>Is 1024x768 screen?: " + ((window.innerWidth == 1024 && window.innerHeight == 768) ? "YES" : "NO") + "</span>");
          </script>
      </html>
      """
    And I have a web server running on host "localhost" and port "8080"
    And I have the feature:
      """
      Feature: Multi-step feature
      Scenario:
        Given I visit the index page
        When I do nothing
        Then I am happy
      """
    And I have the context:
      """
      <?php
      use Behat\MinkExtension\Context\RawMinkContext;
      class FeatureContext extends RawMinkContext
      {
          /**
           * @Given I visit the index page
           */
          function passingStep()
          {
            $this->visitPath('index.html');
          }

          /**
           * @When I do nothing
           */
          function iDoNothing()
          {
            return true;
          }

          /**
           * @Then I am happy
           */
          function iAmHappy()
          {
            echo $this->getSession()->getPage()->getContent();
          }
      }
      """

  Scenario: Set window to maximum size
    Given I have the configuration:
      """
      default:
        extensions:
          Behat\MinkExtension:
            base_url: 'http://localhost:8080'
            sessions:
              default:
                selenium2:
                  wd_host: http://localhost:4444/wd/hub
                  browser: phantomjs

          Bex\Behat\BrowserInitialiserExtension: ~
      """
    When I run Behat
    Then I should see the message "Is full screen?: YES"

  Scenario: Set window to given size
    Given I have the configuration:
      """
      default:
        extensions:
          Behat\MinkExtension:
            base_url: 'http://localhost:8080'
            sessions:
              default:
                selenium2:
                  wd_host: http://localhost:4444/wd/hub
                  browser: phantomjs

          Bex\Behat\BrowserInitialiserExtension:
            browser_window_size: 1024x768
      """
    When I run Behat
    Then I should see the message "Is 1024x768 screen?: YES"

  Scenario: Give error on wrong size configuration
    Given I have the configuration:
      """
      default:
        extensions:
          Behat\MinkExtension:
            base_url: 'http://localhost:8080'
            sessions:
              default:
                selenium2:
                  wd_host: http://localhost:4444/wd/hub
                  browser: phantomjs

          Bex\Behat\BrowserInitialiserExtension:
            browser_window_size: asdf
      """
    When I run Behat
    Then I should see the message "Invalid browser size: asdf. Valid values: 'max' or 'WIDTHxHEIGHT"

  Scenario: Does not show the unsupported driver action errors
    Given I have the configuration:
      """
      default:
        extensions:
          Behat\MinkExtension:
            base_url: 'http://localhost:8080'
            sessions:
              default:
                goutte: ~

          Bex\Behat\BrowserInitialiserExtension:
            browser_window_size: 1024x768
      """
    When I run Behat
    Then I should not see the message "Window resizing is not supported by Behat\Mink\Driver\GoutteDriver"
