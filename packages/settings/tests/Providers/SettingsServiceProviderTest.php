<?php

namespace Settings\Providers;

use Realty\Interfaces\SettingsServiceInterface;
use Settings\Services\SettingsService;
use Tests\TestCase;

class SettingsServiceProviderTest extends TestCase
{
    public function testShouldBindsSettingsService()
    {
        $this->assertInstanceOf(SettingsService::class, $this->app->make(SettingsServiceInterface::class));
    }
}
