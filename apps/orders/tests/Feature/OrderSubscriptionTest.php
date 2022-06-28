<?php

namespace Tests\Feature;

use App\Enums\OrderSubscriptionTypeEnum;
use App\Models\Order;
use App\Models\OrderSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderSubscriptionTest extends TestCase
{

    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        OrderSubscription::factory()->for(
            Order::factory()->create(), "order"
        )->create();
    }


    public function test_get_order_subscription(): void
    {
        $order = Order::first();
        $response = $this->get('api/v1/orders/' . $order->id . '/subscriptions');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                "status",
                "data" => [
                    "data" => [
                        [

                            "id",
                            "subscribable",
                            "type"

                        ]
                    ],
                    "pagination" => [
                        "total",
                        "count",
                        "per_page",
                        "current_page",
                        "total_pages"
                    ]


                ],
                "code"

            ]);
    }

    public function test_show_order_subscription(): void
    {
        $order = Order::first();
        $response = $this->get('api/v1/orders/' . $order->id . '/subscriptions/' . $order->subscriptions->first()->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" =>
                    [
                        "id",
                        "subscribable",
                        "type"
                    ],
                "code",
            ]);
    }


    public function test_update_order_subscription(): void
    {
        $order = Order::first();
        $data = [
            'id' => $order->subscriptions->first()->id,
            'type' => $this->faker->randomElement(OrderSubscriptionTypeEnum::cases())->value,
            'subscribed' => $this->faker->boolean()
        ];
        $response = $this->put('api/v1/orders/' . $order->id . '/subscriptions/' . $order->subscriptions->first()->id, $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" =>
                    [
                        "id",
                        "subscribable",
                        "type"
                    ],
                "code",
            ]);

        $this->assertDatabaseHas('order_subscriptions', $data);
    }
}
