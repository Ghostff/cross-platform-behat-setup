<?php

declare(strict_types=1);

namespace BehatContexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Testwork\Tester\Result\TestResult;
use BehatContexts\contexts\Spinner;

class FeatureContext extends MinkContext implements Context
{
    use Spinner;

    /**
     * @Given /^I set browser window size to "([^"]*)" x "([^"]*)"$/
     * @param int $width
     * @param int $height
     */
    public function iSetBrowserWindowSizeToX($width, $height)
    {
        $this->getSession()->resizeWindow((int) $width, (int) $height, 'current');
    }

    /**
     * @When /^I wait for name (\d+) seconds$/
     * @param int $seconds
     */
    public function iWaitForSeconds($seconds)
    {
        $this->getSession()->wait($seconds * 1000);
    }

    /**
     * Captures a screenshot and saves it to the screenshot directory.
     *
     * @When  /^(?:I )?take a screenshot(?: named "(?P<name>(?:[^"]|\\")*)")?$/
     * @param string $name the name for the screenshot file (excluding path and extension)
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     */
    public function takeScreenShot($name = 'screenshot')
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, __DIR__ . '/../screenshots/') . $name . time();

        file_put_contents("{$path}.png", $this->getSession()->getDriver()->getScreenshot());
        file_put_contents("{$path}.html", $this->getSession()->getDriver()->getContent());
    }

    /**
     * Captures screenshots of failed scenarios.
     *
     * @AfterStep
     * @param AfterStepScope $scope
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     */
    public function takeScreenShotAfterFailedStep(AfterStepScope $scope): void
    {
        if (TestResult::FAILED === $scope->getTestResult()->getResultCode())
        {
            $driver = $this->getSession()->getDriver();

            if (! ($driver instanceof Selenium2Driver)) {
                return;
            }

            $file_name = basename($scope->getFeature()->getFile()) . "({$scope->getStep()->getText()})";
            // Remove anything which isn't a word, whitespace, number
            // or any of the following characters -_~,;[]().
            $file_name = mb_ereg_replace('([^\w\s\d\-_~,;\[\]\(\).])', '', $file_name);
            // Remove any runs of periods
            $file_name = mb_ereg_replace('([\.]{2,})', '', $file_name);
            // Replace whitespace with underscores
            $file_name = mb_ereg_replace('(\s+)', '_', $file_name);

            $this->takeScreenShot($file_name);
        }
    }
}
