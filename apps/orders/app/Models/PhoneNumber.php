<?php

namespace App\Models;

use App\Interfaces\SubscribableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property mixed|string $number
 */
class PhoneNumber extends Model implements SubscribableInterface
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function orderSubscription(): MorphToMany
    {
        return $this->morphToMany(OrderSubscription::class, "subscribable");
    }
}
