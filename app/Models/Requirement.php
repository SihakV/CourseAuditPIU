<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Requirement extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    public $table = 'requirements';

    public ?int $num_of_courses_fulfilled = null;

    protected $fillable = [
        'type_id',
        'studyplan_id',
        'min_course'
    ];

    public $appends = [
        'num_of_courses_fulfilled'
    ];

    public function studyPlan()
    {
        return $this->belongsTo(studyplans::class, 'studyplan_id');
    }

    public function type()
    {
        return $this->belongsTo(Types::class, 'type_id');
    }

    public function numOfCoursesFulfilled(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->num_of_courses_fulfilled,
            set: fn ($val) => $this->num_of_courses_fulfilled = $val
        );
    }
}
