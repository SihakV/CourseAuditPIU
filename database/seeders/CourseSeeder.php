<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = Course::create([
            'name' => 'course 1',
            'code_name' => 'c1',
            'credit' => '3',
        ]);
        $type1 = Types::find(1);

        $type2 = Types::find(2);
        $course->types()->attach([
            $type1->id,
            $type2->id
        ]);
    }
}
