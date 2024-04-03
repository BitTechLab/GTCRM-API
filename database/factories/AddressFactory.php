<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => Arr::random(['customer', 'lead', 'contact', 'company', 'sale']),
            'reference_id' => $this->faker->numberBetween(1, 100),
            'address_1' => $this->faker->streetAddress(),
            'address_2' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country_id' => $this->faker->numberBetween(1, 100),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'address_type' => Arr::random(['billing', 'shipping', 'work', 'home', null]),
        ];
    }
}
