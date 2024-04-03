<?php

namespace Tests\Feature;

use Database\Seeders\CustomerSeeder;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseTruncation;

    /**
     * A basic feature test example.
     */
    public function test_customer_api_returns_data(): void
    {
        $this->seed(CustomerSeeder::class);

        $response = $this->get('/api/v1/customers');

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->where('count', 10)
                ->where('total', 100) // 100 items added by seeder
                ->has('data', 10)
                ->has(
                    'data.0',
                    fn (AssertableJson $json) =>
                    $json->hasAll(['id', 'name', 'email'])
                        ->where('id', 1)
                )
        );
    }
}
