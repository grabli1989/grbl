<?php

namespace User\Subscribers;

use Realty\Interfaces\SettingsServiceInterface;
use User\Events\ResetPasswordEvent;
use User\Events\UserRegisteredEvent;
use User\Interfaces\SmsServiceInterface;
use User\Models\User;

class PhoneConfirmationCodeSubscriber
{
    private const VERIFICATION_MESSAGE = '[Realty]Verification code: %s. Valid in %d minutes.';

    private const VALID_MINUTES = 30;

    private const SENDER = 'Realty';

    private SmsServiceInterface $smsService;

    private SettingsServiceInterface $settingsService;

    /**
     * Create the event listener.
     *
     * @param  SmsServiceInterface  $smsService
     * @param  SettingsServiceInterface  $settingsService
     */
    public function __construct(SmsServiceInterface $smsService, SettingsServiceInterface $settingsService)
    {
        $this->smsService = $smsService;
        $this->settingsService = $settingsService;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegisteredEvent|ResetPasswordEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent|ResetPasswordEvent $event): void
    {
        $user = $event->getUser();

        $this->smsService->send($user->phone, $this->makeMessage($user), $this->getSender(), $this->getCallbackUrl());
    }

    /**
     * @param  User  $user
     * @return string
     */
    private function makeMessage(User $user): string
    {
        if (! $messageTemplate = $this->settingsService->get('phone-confirmation-code-message-template')) {
            $messageTemplate = self::VERIFICATION_MESSAGE;
        }

        if (! $validMinutes = $this->settingsService->get('phone-confirmation-code-valid-minutes')) {
            $validMinutes = self::VALID_MINUTES;
        }

        $code = $user->getCode();

        return sprintf($messageTemplate, $code, $validMinutes);
    }

    /**
     * @return string
     */
    private function getSender(): string
    {
        if (! $sender = $this->settingsService->get('phone-sender')) {
            $sender = self::SENDER;
        }

        return $sender;
    }

    /**
     * @return string
     */
    private function getCallbackUrl(): string
    {
        return route('sms.report.callback');
    }
}
