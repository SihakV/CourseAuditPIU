<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\UserGrade;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {

        $semester = [1, 2, 3, 4, 5, 6, 7, 8];

        /** @var \App\Models\User */
        $user = auth()->user();
        $studyplan = $user->getStudyPlan();

        $courses = $studyplan
            ?->courses()
            ->whereHas(
                'users',
                fn ($q) => $q->where('users.id', $user->id)
            )
            ->get() ?? collect();

        $courses->push(
            ...$studyplan?->courses()->whereNotIn('courses.id', $courses->pluck('id'))->get() ?? collect()
        );

        $courseGroups = $courses->groupBy('pivot.semester') ?? collect();

        return view('student.index', [
            'semester' => $semester,
            'user' => $user,
            'studyplan' => $studyplan,
            'courseGroups' => $courseGroups,
            'gradefill' => UserGrade::getGradeMap(),
        ]);
    }
    public function dashboard()
    {
        $semester = [1, 2, 3, 4, 5, 6, 7, 8];
        /**@var \App\Models\User  */
        $user = auth()->user();
        $studyplan = $user->getStudyPlan();
        /** @var \App\Models\User */
        $user = auth()->user();
        return view('student.dashboard', [
            'semester' => $semester,
            'user' => $user,
            'studyplan' => $studyplan
        ]);
    }

    public function submit(Request $request)
    {
        $input = $request->all();
        $user = auth()->user();

        foreach ($input['course_grade'] as $sem => $courseGrade) {
            foreach ($courseGrade as $courseId => $gradeNum) {
                if (!$gradeNum) {
                    UserGrade::where('user_id', $user->id)
                        ->where('course_id', $courseId)
                        ->where('semester', $sem)
                        ->delete();
                } else {
                    UserGrade::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'course_id' => $courseId,
                        ],
                        [
                            'semester' => $sem,
                            'grades' => $gradeNum,
                        ]
                    );
                }
            }
        }
        activity('ChangeGrade')->log($user->name . ' changed their grades');
        return back();
    }
}
