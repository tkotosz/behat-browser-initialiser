<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Bex\Behat\Context\TestRunnerContext;


class FeatureContext implements SnippetAcceptingContext
{
    /** @var TestRunnerContext $testRunnerContext */
    private $testRunnerContext;

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->testRunnerContext = $environment->getContext('Bex\Behat\Context\TestRunnerContext');
    }

    /**
     * @Given I should see the message :message
     */
    public function iShouldSeeTheMessage($message)
    {
        $output = $this->testRunnerContext->getStandardOutputMessage() .
            $this->testRunnerContext->getStandardErrorMessage();

        $this->assertOutputContainsMessage($output, $message);
    }

    /**
     * @Then I should not see the message :message
     */
    public function iShouldNotSeeTheMessage($message)
    {
        $output = $this->testRunnerContext->getStandardOutputMessage() .
            $this->testRunnerContext->getStandardErrorMessage();

        $this->assertOutputDoesNotContainMessage($output, $message);
    }

    /**
     * @param $message
     */
    private function assertOutputContainsMessage($output, $message)
    {
        if (mb_strpos($output, $message) === false) {
            throw new RuntimeException('Behat output did not contain the given message. Output: ' . PHP_EOL . $output);
        }
    }

    /**
     * @param $message
     */
    private function assertOutputDoesNotContainMessage($output, $message)
    {
        if (mb_strpos($output, $message) !== false) {
            throw new RuntimeException('Behat output contains the given message. Output: ' . PHP_EOL . $output);
        }
    }
}
