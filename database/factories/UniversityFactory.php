<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Location;

class UniversityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker = \Faker\Factory::create("ru_RU");
        return [
            'name' => $this->faker->unique()->company(),
            'address' => $this->faker->address(),
        ];
    }
}
