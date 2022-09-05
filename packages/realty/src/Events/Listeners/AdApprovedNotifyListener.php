<?php

namespace Realty\Events\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Realty\Events\AdApprovedEvent;
use Realty\Interfaces\SettingsServiceInterface;
use Realty\Models\Ad;
use User\Interfaces\SmsServiceInterface;

class AdApprovedNotifyListener implements ShouldQueue
{
    use Queueable;

    private const MESSAGE = '[Realty]Your ad %s is approved.';

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
     * @param  AdApprovedEvent  $event
     * @return void
     */
    public function handle(AdApprovedEvent $event): void
    {
        $ad = $event->getAd();
        $user = $ad->user;

        $this->smsService->send($user->phone, $this->makeMessage($ad), $this->getSender(), $this->getCallbackUrl());
    }

    /**
     * @param  Ad  $ad
     * @return string
     */
    private function makeMessage(Ad $ad): string
    {
        if (! $messageTemplate = $this->settingsService->get('ad-approval-message-template')) {
            $messageTemplate = self::MESSAGE;
        }

        return sprintf($messageTemplate, $ad->caption);
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
