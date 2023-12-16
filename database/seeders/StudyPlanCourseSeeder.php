<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\studyplans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyPlanCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan=studyplans::first();
        $course=Course::first();

        $plan->courses()->attach($course->id,[
            'semester'=>1
        ]);
    }
}
