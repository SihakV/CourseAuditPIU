<?php

namespace App\Models;

use App\Support\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studyplans extends Model
{
    use HasFactory, Searchable;
    /**
     * Assignable
     * @var array
     */
    protected $fillable = [
        'name',
        'min_cgpa'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'study_plan_courses', 'studyplan_id', 'course_id')
            ->withPivot(['semester']);
    }
    public function types()
    {
        return $this->belongsToMany(Types::class, 'requirements', 'studyplan_id', 'type_id')
            ->withPivot(['id', 'min_course'])
            ->as('requirement')
            ->using(Requirement::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class, 'studyplan_id');
    }
}
