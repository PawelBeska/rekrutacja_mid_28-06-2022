<?php

namespace App\Models;

use App\Enums\OrderSubscriptionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property bool|mixed $subscribed
 * @property \App\Enums\OrderSubscriptionTypeEnum|mixed $type
 */
class OrderSubscription extends Model
{
    use HasFactory;

    public $casts = [
        "type" => OrderSubscriptionTypeEnum::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subscribable(): MorphTo
    {
        return $this->morphTo();
    }
}
