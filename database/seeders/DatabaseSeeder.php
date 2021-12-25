<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Direction;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Chair;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $facultyIds = Faculty::factory(15)->create()->pluck("id")->toArray();

        $chairIds = Chair::factory(50)
            ->state(new Sequence(function ($sequence) use ($facultyIds) {
                return ['faculty_id' => Arr::random($facultyIds)];
            }))
            ->create()->pluck('id')->toArray();

        $universityIds = University::factory(10)->create()->each(function ($university) use ($chairIds) {
            $university->chairs()->sync(Arr::random($chairIds, rand(5, 10)));
            foreach ($university->chairs()->get()->pluck('id')->toArray() as $chairId) {
                for ($c=1; $c <= rand(1,6); $c++) {
                    $course = Course::factory()->state([
                        'number' => $c,
                        'chair_id' => $chairId,
                        'university_id' => $university->id
                    ])->create();

                    Group::factory(rand(1,2))->for($course)->create()
                        ->each(function ($group) {
                            $group->students()->saveMany(
                                Student::factory(rand(5,10))->state(['role' => false, 'group_id' => $group->id])->create()
                            );
                        });
                }
            }
        })->pluck("id")->toArray();


    }
}
