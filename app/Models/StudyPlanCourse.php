<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyPlanCourse extends Model
{
    use HasFactory;

    protected $fillable=[
        'course_id',
        'studyplan_id',
        'semester'
    ];

    public function studyPlan() {
        return $this->belongsTo(studyplans::class, 'studyplan_id');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }    
}
