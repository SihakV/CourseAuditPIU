<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Types;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Types::create([
            'name'=> 'DE'
        ]);
        Types::create([
            'name'=> 'Core'
        ]);
        Types::create([
            'name'=> 'GE'
        ]);
        Types::create([
            'name'=> 'F-Core'
        ]);
        Types::create([
            'name'=> 'F-Eng'
        ]);
        Types::create([
            'name'=> 'F-SocSci'
        ]);
        Types::create([
            'name'=> 'F-MathSciTech'
        ]);
        Types::create([
            'name'=> 'F-KHStudies'
        ]);
        Types::create([
            'name'=> 'Math'
        ]);
    }
}
