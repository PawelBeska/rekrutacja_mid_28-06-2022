<?php

namespace App\Services;

use App\Enums\OrderSubscriptionTypeEnum;
use App\Interfaces\SubscribableInterface;
use App\Models\Order;
use App\Models\OrderSubscription;
use App\Models\PhoneNumber;

class OrderSubscriptionService
{
    public function __construct(
        private OrderSubscription $orderSubscription = new OrderSubscription()
    )
    {
    }

    /**
     * @return \App\Models\OrderSubscription
     */
    public function getOrderSubscription(): OrderSubscription
    {
        return $this->orderSubscription;
    }

    public function assignData(
        Order                     $order,
        SubscribableInterface     $subscribable,
        OrderSubscriptionTypeEnum $type,
        bool                      $subscribed,
    ): static
    {
        $this->orderSubscription->order()->associate($order);
        $this->orderSubscription->subscribable()->associate($subscribable);
        $this->orderSubscription->type = $type;
        $this->orderSubscription->subscribed = $subscribed;
        $this->orderSubscription->save();
        return $this;
    }

}
