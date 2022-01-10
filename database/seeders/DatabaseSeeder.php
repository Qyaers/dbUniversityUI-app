<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Direction;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Lecturer;
use App\Models\Program;
use App\Models\Stream;
use App\Models\Student;
use App\Models\Subject;
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

        $subjectIds = Subject::factory(30)->create()->pluck('id')->toArray();

        $universityIds = University::factory(3)->create()->each(function ($university) use ($chairIds, $subjectIds) {
            $university->chairs()->sync(Arr::random($chairIds, rand(5, 10)));
            $university->subjects()->sync(Arr::random($subjectIds, rand(15, 25)));

            $lecturerIds = Lecturer::factory(rand(20,40))->for($university)->create()->each(function ($lecturer) use ($subjectIds) {
                $lecturer->subjects()->sync(Arr::random($subjectIds, rand(1,3)));
            })->pluck('id')->toArray();

            foreach ($university->chairs()->get()->pluck('id')->toArray() as $chairId) {
                $count_courses = rand(1,6);
                for ($c=1; $c <= $count_courses; $c++) {
                    $course = Course::factory()->state([
                        'number' => $c
                    ])->create();

                    Stream::factory()->for($course)->state([
//                        'course_id' => $course->id,
                        'chair_id' => $chairId,
                        'university_id' => $university->id
                    ])->create();

                    Group::factory(rand(1,2))->for($course)->create()
                        ->each(function ($group) {
                            $group->students()->saveMany(
                                Student::factory(rand(5,10))->state(['role' => false, 'group_id' => $group->id])->create()
                            );
                        });

                    $count_programs = rand(10,20);
                    for ($p=0; $p < $count_programs; $p++) {
                        $lecturerId = Arr::random($lecturerIds);
                        $subjectId = Arr::random(Lecturer::query()->where('id','=', $lecturerId)
                            ->join('lecturer_subject', 'lecturer_id','=','lecturers.id')
                            ->get()->pluck('subject_id')->toArray());
                        Program::factory()->state([
                            'hours' => rand(30,120),
                            'subject_id' => $subjectId,
                            'lecturer_id' => $lecturerId
                            ])->for($course)->create();
                    }
                }
            }

        })->pluck("id")->toArray();
    }
}
