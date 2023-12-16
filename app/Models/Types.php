<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
    ];

    public function courses() {
        return $this->belongsToMany(Course::class, 'course_type', 'type_id', 'course_id');
    }

    public function studyPlans() {
        return $this->belongsToMany(studyplans::class, 'requirements', 'type_id', 'studyplan_id')
            ->withPivot(['id', 'min_course'])
            ->as('requirement')
            ->using(Requirement::class);
    }
}
