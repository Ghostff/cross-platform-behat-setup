<?php

declare(strict_types=1);

namespace BehatContexts;


use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use BehatContexts\contexts\Spinner;

class FeatureContext extends MinkContext implements Context
{
    use Spinner;

    /**
     * @Given /^I set browser window size to "([^"]*)" x "([^"]*)"$/
     * @param int $width
     * @param int $height
     */
    public function iSetBrowserWindowSizeToX(int $width, int $height)
    {
        $this->getSession()->resizeWindow($width, $height, 'current');
    }

    /**
     * @When /^I wait for name (\d+) seconds$/
     * @param int $seconds
     */
    public function iWaitForSeconds(int $seconds)
    {
        $this->getSession()->wait($seconds * 1000);
    }
}
