<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Helpers\BaseHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;


    public $fillable = [
        'tracking_number',
    ];

    public $casts = [
        'status' => OrderStatusEnum::class,
    ];

    protected static function booted()
    {
        parent::boot();

        static::creating(function (Order $order) {
            $order->update([
                'tracking_number' => generateTrackingNumber()
            ]);
        });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(OrderSubscription::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function trackingNumber(): Attribute
    {
        return Attribute::Make(
            get: static fn($value) => $value,
            set: static fn($value) => "GK" . Str::padLeft(preg_replace('/\D/', '', $value), "9", "0")
        );
    }

}
