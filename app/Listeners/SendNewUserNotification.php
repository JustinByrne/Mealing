<?php

namespace App\Listeners;

use App\Events\UserVerified;
use App\Notifications\ApproveUser;
use Spatie\Permission\Models\Role;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserNotification
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
     * @param  UserVerified  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        $admins = Role::findByName('Super Admin')->users;

        Notification::send($admins, new ApproveUser($event->user));
    }
}
