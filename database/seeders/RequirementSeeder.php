<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Requirement;
use App\Models\studyplans;
use App\Models\Types;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\Types */
        $type = Types::first();
        $plan = studyplans::first();

        // Requirement::create([
        //     'type_id'=>$type->id,
        //     'studyplan_id'=>$plan->id,
        //     'min_course'=>2,
        // ]);

        $type->studyPlans()->attach($plan->id, [
            'min_course'=>2,
        ]);
    }
}
