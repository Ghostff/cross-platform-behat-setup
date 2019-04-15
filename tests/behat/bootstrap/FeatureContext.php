<?php
/**
 * Created by PhpStorm.
 * User: chrysu
 * Date: 3/15/19
 * Time: 3:13 PM
 */

namespace BehatContexts;


use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use BehatContexts\contexts\ScreenshotContext;
use BehatContexts\contexts\Spinner;

class FeatureContext extends MinkContext implements Context
{
    use Spinner;
    use ScreenshotContext;

    /**
     * @BeforeScenario
     */
    public function resizeWindow()
    {
        $this->getSession()->resizeWindow(1440, 900, 'current');
    }

    /**
     * @When /^I wait for name (\d+) seconds$/
     */
    public function iWaitForSeconds($seconds)
    {
        $this->getSession()->wait($seconds * 1000);
    }
}
