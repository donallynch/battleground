<?php

namespace App\Listeners;

use App\Events\ProfileBeingViewedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventListener
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
     * @param  ProfileBeingViewedEvent  $event
     * @return void
     */
    public function handle(ProfileBeingViewedEvent $event)
    {
        echo'<pre>';
        var_dump("\n\n\nProfileBeingViewedEvent triggered\n");
        var_dump(" - Sending mail to {$event->profileOwner[0]->first_name} {$event->profileOwner[0]->last_name} ({$event->profileOwner[0]->email})");
        var_dump(" - Mail says: {$event->profileOwner[0]->first_name} {$event->profileOwner[0]->last_name} just viewed your profile!");
        echo'</pre>';
    }
}
