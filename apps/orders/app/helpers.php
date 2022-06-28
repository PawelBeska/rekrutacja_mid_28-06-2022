<?php


use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function generateTrackingNumber()
{
    if ($latest_order = Order::query()->latest('created_at')->first()) {
        return (int)preg_replace('/\D/', '', $latest_order->tracking_number) + 1;
    }
    return 1;

}

