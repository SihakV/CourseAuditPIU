<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Types;
use App\Models\Course;
use App\Models\studyplans;
use App\Models\Requirement;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudyplansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyplans = studyplans::searchable([
            'name'
        ])->get();
        return view('studyplans.index')->with('studyplans', $studyplans);
    }
    public function assignGet(studyplans $studyplan)
    {

        return view('studyplans.assign', [
            'years' => AcademicYear::whereNull('studyplan_id')->get(),
            'studyplan' => $studyplan,
        ]);
    }
    public function assignPost(Request $request, studyplans $studyplan)
    {
        $request->validate([
            'years' => ['required', 'array', 'min:1']
        ]);
        $input = $request->all();
        foreach ($input['years'] as $yearId) {
            AcademicYear::find($yearId)->update([
                'studyplan_id' => $studyplan->id
            ]);
        }
        return redirect('/admin/studyplans');
    }
    public function assigned(studyplans $studyplan)
    {
        return view('studyplans.unassign', [
            'years' => AcademicYear::where('studyplan_id', $studyplan->id)->get(),
            'studyplan' => $studyplan,
        ]);
    }
    public function assignRemove(Request $request, studyplans $studyplan)
    {
        $request->validate([
            'years' => ['required', 'array', 'min:1']
        ]);
        $input = $request->all();
        foreach ($input['years'] as $yearId) {
            AcademicYear::find($yearId)->update([
                'studyplan_id' => null
            ]);
        }
        return redirect('/admin/studyplans');
    }

    public function assignStudentGet(studyplans $studyplan)
    {
        return view('studyplans.assignStudent', [
            'students' => User::whereNull('role')->whereNull('custom_studyplan_id')->searchable(['name'])->get(),
            'studyplan' => $studyplan,
        ]);
    }

    public function assignStudentPost(Request $request, studyplans $studyplan)
    {
        $request->validate([
            'students' => ['required', 'array', 'min:1']
        ]);
        $input = $request->all();
        foreach ($input['students'] as $studentId) {
            User::find($studentId)->update([
                'custom_studyplan_id' => $studyplan->id
            ]);
        }
        return redirect('/admin/studyplans');
    }

    public function view(studyplans $studyplan)
    {

        $semester = [1, 2, 3, 4, 5, 6, 7, 8];

        $courseGroups = $studyplan->courses->groupBy('pivot.semester');

        return view('studyplans.view', [
            'semester' => $semester,
            'studyplans' => $studyplan,
            'courseGroups' => $courseGroups
        ]);
    }
    public function list(studyplans $studyplan)
    {
        $semester = [1, 2, 3, 4, 5, 6, 7, 8];
        $courses = Course::query()
            ->whereDoesntHave('studyplan', function ($query) use ($studyplan) {
                return $query->where('studyplans.id', $studyplan->id);
            })
            ->orWhereHas('types', function ($query) {
                $types = ['DE', 'GE'];

                return $query->whereIn('types.name', $types);
            })->searchable(['name', 'code_name', 'types.name'])
            ->get();

        return view('studyplans.list', [
            'courses' => $courses
        ], compact('semester'))->with('studyplans', $studyplan);
    }

    public function listPost(Request $request, studyplans $studyplan)
    {
        $request->validate([
            'courses' => ['required', 'array', 'min:1'],
            'courses.*' => ['required', 'integer', 'exists:courses,id']
        ]);

        $input = $request->all();

        $studyplan->courses()->attach($input['courses'], [
            'semester' => $input['semester']
        ]);
        return redirect('/admin/studyplans/' . $studyplan->id . '/view');
    }

    public function courseRemove(studyplans $studyplan, Course $course)
    {
        $courseId = $course->id;
        $studyplan->courses()->detach($courseId);
        return redirect('/admin/studyplans/' . $studyplan->id . '/view');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('studyplans.create', [
            'types' => Types::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $plan = studyplans::create($input);

        foreach ($input['requirements'] as $typeId => $minCourse) {
            if ($minCourse != null) {
                Requirement::create([
                    'studyplan_id' => $plan->id,
                    'type_id' => $typeId,
                    'min_course' => $minCourse
                ]);
            };
        }
        return redirect('/admin/studyplans')->with('flash_message', 'created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\studyplans  $studyplans
     * @return \Illuminate\Http\Response
     */
    public function show(studyplans $studyplans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\studyplans  $studyplans
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $studyplans = studyplans::find($id);
        return view('studyplans.edit', [
            'types' => Types::all(),
            'requirements' => Requirement::where('studyplan_id', $studyplans->id)->get()
        ])->with('studyplans', $studyplans);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\studyplans  $studyplans
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studyplans = studyplans::find($id);
        $input = $request->all();
        $studyplans->update($input);

        foreach ($input['requirements'] as $typeId => $minCourse) {
            if ($minCourse == null) {
                Requirement::where('studyplan_id', $studyplans->id)->where('type_id', $typeId)->delete();
            } else {
                Requirement::updateOrCreate([
                    'studyplan_id' => $studyplans->id,
                    'type_id' => $typeId,
                ], [
                    'min_course' => $minCourse
                ]);
            }
        }

        return redirect('/admin/studyplans')->with('flash_message', 'edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\studyplans  $studyplans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        studyplans::destroy($id);
        return redirect('/admin/studyplans')->with('flash_message', 'deleted');
    }
}
