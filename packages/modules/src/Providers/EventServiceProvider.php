<?php

namespace Modules\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $config = $this->app->make('modules');

        foreach ($config->all() as $moduleConfig) {
            /** @var $listen array<class-string, array<int, class-string>> */
            $listen = $moduleConfig['listen'] ?? [];
            foreach ($listen as $event => $listeners) {
                $this->eventListen($listeners, $event);
            }
        }
    }

    /**
     * @param  array  $listeners
     * @param  int|string  $event
     * @return void
     */
    private function eventListen(array $listeners, int|string $event): void
    {
        foreach ($listeners as $listener) {
            Event::listen($event, [$listener, 'handle']);
        }
    }
}
