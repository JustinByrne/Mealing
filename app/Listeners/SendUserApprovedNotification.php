<?php

namespace App\Listeners;

use App\Events\UserApproved;
use App\Notifications\ApprovedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserApprovedNotification
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
     * @param  UserApproved  $event
     * @return void
     */
    public function handle(UserApproved $event)
    {
        $event->user->notify(new ApprovedUser($event->user));
    }
}
