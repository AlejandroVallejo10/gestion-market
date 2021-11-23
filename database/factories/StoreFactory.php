<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new \Faker\Provider\es_ES\Person($this->faker));
        $this->faker->addProvider(new \Faker\Provider\es_ES\Address($this->faker));
        return [
            'name' => $this->faker->unique()->city(),
            'admin' => $this->faker->name(),
            'phone' => '31' . $this->faker->randomNumber(7, true),
        ];
    }
}
