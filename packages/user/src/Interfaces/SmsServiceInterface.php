<?php

namespace User\Interfaces;

interface SmsServiceInterface
{
    /**
     * @param  string  $phone
     * @param  string  $message
     * @param  string|null  $callbackUrl
     * @return array|null
     */
    public function send(string $phone, string $message, string $sender = null, string $callbackUrl = null): array|null;
}
