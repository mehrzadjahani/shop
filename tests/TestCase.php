<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function hasMethod($class, $method): void
    {
        $this->assertTrue(
            method_exists($class, $method),
            "$class must have method $method"
        );
    }


}
