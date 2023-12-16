<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserGrade extends Pivot
{
    use HasFactory;

    public $table = 'user_grades';

    protected $fillable = [
        'user_id',
        'course_id',
        'grades',
        'semester'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function letterGrade(): Attribute
    {
        return Attribute::make(
            get: function () {
                $numGrade = number_format($this->grades, 1);



                return static::getGradeMap()[$numGrade] ?? 'Invalid grade';
            }
        );
    }

    public static function getGradeMap()
    {
        return  [
            '0.0' => 'F',
            '1.0' => 'DD',
            '1.5' => 'DC',
            '2.0' => 'CC',
            '2.5' => 'CB',
            '3.0' => 'BB',
            '3.5' => 'BA',
            '4.0' => 'AA'
        ];
    }
}
