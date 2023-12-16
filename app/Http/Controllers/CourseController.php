<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Types;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('types')->searchable([
            'name', 'code_name', 'types.name'
        ])->get();
        return view('courses.index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create', [
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
        $request->validate([
            'types' => ['required', 'array', 'min:1']
        ]);
        $input = $request->all();
        $course = Course::create($input);
        $course->types()->attach($input['types']);
        return redirect('/admin/courses')->with('flash_message', 'created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = Course::with('types')->find($id);
        return view('courses.edit', [
            'types' => Types::all()
        ])->with('courses', $courses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'types' => ['required', 'array', 'min:1']
        ]);
        $courses = Course::find($id);
        $input = $request->all();
        $courses->update($input);
        $courses->types()->sync($input['types']);
        return redirect('/admin/courses')->with('flash_message', 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::destroy($id);
        return redirect('/admin/courses')->with('flash_message', 'Deleted');
    }
}
