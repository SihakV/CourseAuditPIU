<?php

namespace Database\Seeders;

use App\Models\studyplans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class studyplanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        studyplans::create([
            'name'=>'SP1'
        ]);
    }
}
