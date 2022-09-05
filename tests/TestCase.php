<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param  string  $abstract
     * @param  MockObject  $mockObject
     * @return void
     */
    public function bindMock(string $abstract, MockObject $mockObject): void
    {
        $this->app->bind($abstract, function () use ($mockObject) {
            return $mockObject;
        });
    }
}
