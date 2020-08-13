<?php

namespace App\Listenters;

use App\Events\AdminNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdminNotificationListener
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
     * @param  AdminNotificationEvent  $event
     * @return void
     */
    public function handle(AdminNotificationEvent $event)
    {
        //
    }
}
