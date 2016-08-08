<?php

namespace App\Listeners;

use App\Events\PurchasedPassport;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchasedPassportListen implements ShouldQueue
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
     * @param  PurchasedPassport  $event
     * @return void
     */
    public function handle(PurchasedPassport $event)
    {
        return $event->status;
    }
}
