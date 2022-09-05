<?php

namespace Modules\Providers;

use Illuminate\Config\Repository;
use Tests\TestCase;

class ModulesServiceProviderTest extends TestCase
{
    public function testShouldInstanceModules()
    {
        $this->assertInstanceOf(Repository::class, $this->app->make('modules'));
    }

    public function testResolveCommands()
    {
        $result = \Artisan::call('command:name');
        $this->assertEquals(0, $result);
    }
}
