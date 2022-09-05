<?php

namespace Realty\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Realty\Models\Ad;

class AdRejectedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private Ad $ad;

    private string $reason;

    /**
     * @param  Ad  $ad
     * @param  string  $reason
     */
    public function __construct(Ad $ad, string $reason)
    {
        $this->ad = $ad;
        $this->reason = $reason;
    }

    /**
     * @return Ad
     */
    public function getAd(): Ad
    {
        return $this->ad;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
