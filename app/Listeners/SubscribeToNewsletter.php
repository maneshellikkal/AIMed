<?php

namespace App\Listeners;

use Newsletter;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeToNewsletter
{
    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        while(!Newsletter::subscribeOrUpdate($event->user->email))
        {
            logger('Failed to subscribe for user '.$event->user->email);
        }
    }
}
