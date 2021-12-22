<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\University::factory(10)->create();
        /*\App\Models\Chair::factory(10)->has(University::factory()->count(3))->create();*/
        \App\Models\Chair::factory(30)->create();

        \App\Models\Course::factory(12)->create();
        \App\Models\Direction::factory(6)->create();
        \App\Models\Subject::factory(40)->create();
        \App\Models\Lecturer::factory(20)->create();
        \App\Models\Student::factory(100)->create();
        \App\Models\Group::factory(10)->create();

    }
}
