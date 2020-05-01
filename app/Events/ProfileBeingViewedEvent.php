<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class ProfileBeingViewedEvent
 * @package App\Events
 */
class ProfileBeingViewedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var $profileOwner */
    public $profileOwner;

    /** @var $sessionOwner */
    public $sessionOwner;

    /**
     * ProfileBeingViewedEvent constructor.
     * @param $profileOwner
     * @param $sessionOwner
     */
    public function __construct($profileOwner, $sessionOwner)
    {
        $this->profileOwner = $profileOwner;
        $this->sessionOwner = $sessionOwner;
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
