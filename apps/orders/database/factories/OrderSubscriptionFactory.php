<?php

namespace Database\Factories;

use App\Enums\OrderSubscriptionTypeEnum;
use App\Models\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderSubscription>
 */
class OrderSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subscribable = app($this->faker->randomElement([
            PhoneNumber::class
        ]))->factory()->create();
        return [
            'subscribed' => $this->faker->boolean,
            'type' => $this->faker->randomElement(OrderSubscriptionTypeEnum::cases())->value,
            'subscribable_id' => $subscribable->id,
            'subscribable_type' => get_class($subscribable),
        ];
    }
}
