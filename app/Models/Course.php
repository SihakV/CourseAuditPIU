<?php

namespace App\Models;

use App\Support\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, Searchable;

    /**
     * Assignable
     * @var array
     */
    protected $fillable = [
        'name',
        'code_name',
        'credit',
        'grade'
    ];

    public function studyplan()
    {
        return $this->belongsToMany(studyplans::class, 'study_plan_courses', 'course_id', 'studyplan_id')
            ->withPivot(['semester']);
    }
    public function types()
    {
        return $this->belongsToMany(Types::class, 'course_type', 'course_id', 'type_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_grades', 'course_id', 'user_id')
            ->withPivot(['grades', 'semester'])
            ->using(UserGrade::class)
            ->as('grades');
    }
}
