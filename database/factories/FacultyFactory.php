<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FacultyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(rand(3,5)),
        ];
    }
}
