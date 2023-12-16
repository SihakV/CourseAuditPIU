<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Support\Searchable;
use Attribute;
use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;


    public const ROLE_ADMIN = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'academic_year_id',
        'year_level',
        'custom_studyplan_id',
        'role',
        'cgpa',
        'credit',
    ];

    public function getStudyPlan(): ?studyplans
    {
        return $this->custom_studyplan_id
            ? $this->customStudyPlan
            : $this->academicYear?->studyplan;
    }

    public function customStudyPlan()
    {
        return $this->belongsTo(studyplans::class, 'custom_studyplan_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === User::ROLE_ADMIN;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_grades', 'user_id', 'course_id')
            ->withPivot(['grades', 'semester'])
            ->using(UserGrade::class)
            ->as('grades');
    }

    public function getCGPA()
    {
        $studyPlan = $this->getStudyPlan();

        if (!$studyPlan) return null;

        $currentSemester = $this->getCurrentSemester();

        $courses = $studyPlan->courses()
            ->wherePivot('semester', '<=', $currentSemester)
            ->get()
            ->unique('id');

        // get gpa of courses
        // cgpa =[Course1(gradeNum*Credit) + Course2(gradeNum*Credit)]/ course1credit + course2credit
        // foreach course numerator+= gradeNum*credit, denominator+= credit
        // cgpa= numerator/denominator
        $numerator = 0;
        $denominator = 0;
        foreach ($courses as $course) {
            if ($this->getCourseGrade($course) != null) {
                $numerator += $course->credit * ($this->getCourseGrade($course)?->grades ?? 0);
                $denominator += $course->credit;
            }
        }
        if ($denominator != 0)
            return +number_format($numerator / $denominator, 2);
        else
            return 0;
    }

    public function getCourseGrade(Course $course): ?UserGrade
    {
        return $this->courses()->where('courses.id', $course->id)->first()?->grades;
    }

    public function getCurrentSemester()
    {
        $level = $this->year_level;

        $currentSemesters = [
            'Freshman' => 2,
            'Sophomore' => 4,
            'Junior' => 6,
            'Senior' => 8
        ];

        return $currentSemesters[$level] ?? 0;
    }
    //foreach($user->get as requ)
    public function getUserCourseRequirements()
    {
        $studyPlan = $this->getStudyPlan();

        if (!$studyPlan) return collect();

        $courseTypes = $studyPlan->types;
        $courses = $studyPlan->courses()->with('types')->get()->unique('id');
        $reqs = collect();

        foreach ($courseTypes as &$type) {
            $courseCountInType = 0;

            foreach ($courses as $course) {
                if ($course->types->where('id', $type->id)->isEmpty()) continue;

                $grade = $this->getCourseGrade($course);

                if (!$grade) continue;

                $specialTypes = collect(['Core', 'Math', 'F-MathSciTech', 'F-Core']);
                $courseTypesNames = $course->types->pluck('name');
                $isSpecialType = $courseTypesNames->intersect($specialTypes)->isNotEmpty();

                if ($isSpecialType && $grade->grades >= 1.5) {
                    $courseCountInType++;
                }

                if (!$isSpecialType && $grade->grades >= 1.0) {
                    $courseCountInType++;
                }
            }

            $req = $type->requirement;
            $req->num_of_courses_fulfilled = $courseCountInType;
            $reqs[] = $req;
        }

        return $reqs;
        // for each type: courses
        // init courseCountInType
        // foreach course, 
        // if course has a Core, Math, F-MathSciTech, or F-Core AND 1.5 or above, count ++
        // if course grade is 1.0 or above, courseCountInType++
        // $type->requirement->num_of_courses_fulfilled = courseCountInType

    }

    public function getUserCredit()
    {
        $studyPlan = $this->getStudyPlan();

        if (!$studyPlan) return null;

        $currentSemester = $this->getCurrentSemester();

        $courses = $studyPlan->courses()
            ->wherePivot('semester', '<=', $currentSemester)
            ->get()
            ->unique('id');
        $credit = 0;
        foreach ($courses as $course) {
            $grade = $this->getCourseGrade($course);
            if ($grade && $grade->grades >= 1.0) {
                $credit += $course->credit;
            }
        }
        return $credit;
    }
    public function getFailedCourses()
    {
        $studyPlan = $this->getStudyPlan();

        if (!$studyPlan) return collect();

        $courses = $studyPlan->courses()->with('types')->get()->unique('id');
        $failed = collect();
        $count = 0;
        foreach ($courses as $course) {
            $grade = $this->getCourseGrade($course);

            if (!$grade) continue;

            $specialTypes = collect(['Core', 'Math', 'F-MathSciTech', 'F-Core']);
            $courseTypesNames = $course->types->pluck('name');
            $isSpecialType = $courseTypesNames->intersect($specialTypes)->isNotEmpty();

            if ($isSpecialType && $grade->grades < 1.5) {
                $failed[] = $course;
            }

            if (!$isSpecialType && $grade->grades < 1.0) {
                $failed[] = $course;
            }
        }

        return $failed;
    }
}
