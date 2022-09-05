<?php

namespace Phone\SmsProvider;

use User\Interfaces\SmsServiceInterface;

class SmsProvider implements SmsServiceInterface
{
    public function send(string $phone, string $message, string $sender = null, string $callbackUrl = null): array|null
    {
        logger("Sending $message to $phone from $sender. Callback: $callbackUrl");

        return null;
    }
}
