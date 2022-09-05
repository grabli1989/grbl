<?php

namespace Realty\Events\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Realty\Events\AdRejectedEvent;
use Realty\Interfaces\SettingsServiceInterface;
use Realty\Models\Ad;
use User\Interfaces\SmsServiceInterface;

class AdRejectedNotifyListener implements ShouldQueue
{
    use Queueable;

    private const MESSAGE = '[Realty]Your ad %s is rejected. Reason: %s.';

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
     * @param  AdRejectedEvent  $event
     * @return void
     */
    public function handle(AdRejectedEvent $event): void
    {
        $ad = $event->getAd();
        $user = $ad->user;
        $reason = $event->getReason();

        $this->smsService->send($user->phone, $this->makeMessage($ad, $reason), $this->getSender(), $this->getCallbackUrl());
    }

    /**
     * @param  Ad  $ad
     * @return string
     */
    private function makeMessage(Ad $ad, string $reason): string
    {
        if (! $messageTemplate = $this->settingsService->get('ad-rejected-message-template')) {
            $messageTemplate = self::MESSAGE;
        }

        return sprintf($messageTemplate, $ad->caption, $reason);
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
