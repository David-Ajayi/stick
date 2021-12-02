<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NowInStock;
use App\Notifications\ImportantStockUpdate;

class SendStockUpdateNotification
{
    /**
     * Handle the event.
     *
     * @param  NowInStock  $event
     * @return void
     */
    public function handle(NowInStock $event)
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
        //only one users in this application. if it were real we would graab all subscibers to a product to notify
    }
}
