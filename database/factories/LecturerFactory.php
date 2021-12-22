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
        $this->faker = \Faker\Factory::create("ru_RU");
        return [
            "firstName"=>$this->faker->lastName(),
            "name"=>$this->faker->firstName(),
            "secondName"=>$this->faker->firstNameMale(),
            "position"=>$this->faker->word(),
        ];
    }
}
