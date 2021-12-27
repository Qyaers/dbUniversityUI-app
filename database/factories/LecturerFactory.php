<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->lastName,
            'name' => $this->faker->firstName,
            'secondName' => $this->faker->firstNameMale,
            'position' => $this->faker->word,
        ];
    }
}
