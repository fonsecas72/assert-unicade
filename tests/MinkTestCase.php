<?php

namespace UnicadeAssert\Tests;

use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\Mink\Driver\GoutteDriver;
use Goutte\Client;

class MinkTestCase extends TestCase
{
    /** @var Mink */
    protected $mink;
    
    protected static $url = 'http://www.google.com/';

    public function setup()
    {
        $this->initMinkTesting();
    }

    public function tearDown()
    {
        if (is_object($this->mink)) {
            $this->mink->stopSessions();
        }
    }

    protected function onNotSuccessfulTest(\Exception $e)
    {
        parent::onNotSuccessfulTest($e);
    }

    private function initMinkTesting()
    {
        $this->mink = $this->startMink();
    }

    /**
     *
     * @return Mink
     */
    private function startMink()
    {
        $mink = new Mink(array(
            'goutte' => new Session(new GoutteDriver(new Client())),
        ));
        $mink->setDefaultSessionName('goutte');
        $mink->getSession()->visit(self::$url);
        
        return $mink;
    }
    
    /**
     *
     * @param string $path url after base - e.g. 'admin'
     */
    protected function visitPath($path)
    {
        $this->mink->getSession()->visit($this->locatePath($path));
        self::printDebugMsg($path);
    }

    /**
     * Adds some given $path to the base path URL and return the Full URL as a string
     * 
     * @param string $path url after base - e.g. 'admin'
     *
     * @return string
     */
    private function locatePath($path)
    {
        $startUrl = rtrim(self::$url, '/') . '/';

        return 0 !== strpos($path, 'http') ? $startUrl . ltrim($path, '/') : $path;
    }
}
