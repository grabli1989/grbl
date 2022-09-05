<?php

namespace User\Subscribers;

use User\Events\UserConfirmedByPhoneEvent;

class NotifyUserAboutConfirmedByPhoneSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserConfirmedByPhoneEvent  $event
     */
    public function handle(UserConfirmedByPhoneEvent $event): void
    {
        //
    }
}
