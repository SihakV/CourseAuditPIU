<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Types;
use Illuminate\Database\Seeder;
use Database\Seeders\TypeSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TypeSeeder::class,
            CourseSeeder::class,
            studyplanSeeder::class,
            AcademicYearSeeder::class,

            RequirementSeeder::class,
            UserGradeSeeder::class,
            StudyPlanCourseSeeder::class
        ]);
       
    }
}
