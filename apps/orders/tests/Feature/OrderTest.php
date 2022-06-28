<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderSubscription;
use App\Models\PhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{

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

        ray($response->json());
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [
                    "data" => [
                        [
                            "id"
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


            ]);

    }
}
