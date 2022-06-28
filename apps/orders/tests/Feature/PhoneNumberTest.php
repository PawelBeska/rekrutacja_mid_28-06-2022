<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderSubscription;
use App\Models\PhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhoneNumberTest extends TestCase
{

    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        OrderSubscription::factory()->for(
            Order::factory()->create(), "order"
        )->create();
    }

    public function test_get_phone_numbers()
    {
        $response = $this->get('api/v1/phoneNumbers');

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [
                    "data" => [
                        [
                            "id",
                            "number"
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

    public function test_show_phone_numbers()
    {
        $response = $this->get('api/v1/phoneNumbers/' . PhoneNumber::first()->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "status",
                "data" => [
                    "id",
                    "number"
                ],
                "code"


            ]);
    }
}
