<?php

namespace Tests\Feature;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderSubscription;
use App\Models\PhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        OrderSubscription::factory()->for(
            Order::factory()->create(), "order"
        )->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_orders()
    {
        $response = $this->get('api/v1/orders');
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [
                    "data" => [
                        [
                            "id",
                            "status",
                            "tracking_number",
                            "subscriptions" => [
                                [
                                    "id",
                                    "subscribable",
                                    "type"
                                ]
                            ]
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


    public function test_get_orders_with_search()
    {
        $response = $this->get(route('orders.index', [
            'search' => Order::first()->tracking_number,
            'searchBy' => "tracking_number"
        ]));
        ray($response->json());
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [
                    "data" => [
                        [
                            "id",
                            "status",
                            "tracking_number",
                            "subscriptions" => [
                                [
                                    "id",
                                    "subscribable",
                                    "type"
                                ]
                            ]
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

    public function test_show_order(): void
    {
        $response = $this->get('api/v1/orders/' . Order::first()->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [

                    "id",
                    "status",
                    "tracking_number",
                    "subscriptions" => [
                        [
                            "id",
                            "subscribable",
                            "type"
                        ]
                    ]

                ],
                "code",
            ]);

    }

    public function test_update_order(): void
    {
        $status = $this->faker->randomElement(OrderStatusEnum::cases())->value;
        $response = $this->put('api/v1/orders/' . Order::first()->id,
            [
                "status" => $status
            ]
        );
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [

                    "id",
                    "status",
                    "tracking_number",
                    "subscriptions" => [
                        [
                            "id",
                            "subscribable",
                            "type"
                        ]
                    ]

                ],
                "code",
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => Order::first()->id,
            'status' => $status
        ]);
    }
}
