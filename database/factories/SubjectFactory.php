<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
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
            "name"=>$this->faker->unique()->word(),
            "hours"=>$this->faker->numberBetween(36,150),
        ];
    }
}
