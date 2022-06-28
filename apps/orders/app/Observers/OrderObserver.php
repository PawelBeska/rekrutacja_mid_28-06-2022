<?php

namespace App\Observers;

use App\Events\OrderChangedStatusEvent;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "updating" event.
     *
     * @param \App\Models\Order $order
     * @return void
     */
    public function updating(Order $order): void
    {
        if ($order->isDirty('status') && $order->getOriginal('status')) {
            event(new OrderChangedStatusEvent($order));
        }
    }
}
