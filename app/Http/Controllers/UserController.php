<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::searchable([
            'name', 'year_level'
        ])->whereNull('role')->get();
        return view('users.index')->with('users', $users);
    }

    public function promoteGet()
    {
        $users = User::whereNull('role')->whereNot('year_level', 'Senior')->get();
        return view('users.promote')->with('users', $users);
    }

    public function promote(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'students' => ['required', 'array', 'min:1']
        ]);

        return DB::transaction(function () use ($input) {
            foreach ($input['students'] as $studentID) {
                $user = User::findOrFail($studentID);

                $nextLevel = match ($user->year_level) {
                    'Freshman' => 'Sophomore',
                    'Sophomore' => 'Junior',
                    'Junior' => 'Senior',
                    'Senior' => null,
                    default => null,
                };

                if ($nextLevel) {
                    $user->update([
                        'year_level' => $nextLevel
                    ]);
                }
            }

            return redirect('/admin/users');
        });
    }

    public function view($id)
    {
        $semester = [1, 2, 3, 4, 5, 6, 7, 8];
        $user = User::with('courses')->find($id);
        $studyplan = $user->getStudyPlan();
        $courseGroups = $studyplan?->courses->groupBy('pivot.semester') ?? collect();
        return view('users.view', [
            'semester' => $semester,
            'user' => $user,
            'studyplan' => $studyplan,
            'courseGroups' => $courseGroups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $year_level = ['Freshman', 'Sophomore', 'Junior', 'Senior'];
        return view('users.create', compact('year_level'), [
            'academicyears' => AcademicYear::all()
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

        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return redirect('/admin/users')->with('flash_message', 'created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $year_level = ['Freshman', 'Sophomore', 'Junior', 'Senior'];
        $users = User::find($id);
        return view('users.edit', compact('year_level'), ['academicyears' => AcademicYear::all()])->with('users', $users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        $input = $request->all();
        $input['password'] = isset($input['password']) ? Hash::make($input['password']) : $users->password;
        $users->update($input);
        return redirect('/admin/users')->with('flash_message', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/admin/users')->with('flash_message', 'deleted');
    }

    public function destroyPlan($id)
    {
        User::find($id)->update([
            'custom_studyplan_id' => null
        ]);
        return redirect('/admin/users');
    }
}
