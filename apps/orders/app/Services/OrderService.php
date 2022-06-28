<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Models\Order;

class OrderService
{
    public function __construct(
        private Order $order = new Order()
    )
    {
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function assignData(
        OrderStatusEnum $status,
    )
    {

    }
}
