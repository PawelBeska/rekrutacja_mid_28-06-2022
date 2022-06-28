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

    /**
     * @return \App\Models\Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param \App\Enums\OrderStatusEnum $status
     * @return $this
     */
    public function assignData(
        OrderStatusEnum $status,
    ): static
    {
        $this->order->status = $status;
        $this->order->save();
        return $this;
    }
}
