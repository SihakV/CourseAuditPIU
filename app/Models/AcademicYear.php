<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    /**
     * Assignable
     * @var array
     */
    protected $fillable= [
        'year',
        'studyplan_id'
    ];
    public function studyplan(){
        return $this->belongsTo(studyplans::class, 'studyplan_id');
    }
}
