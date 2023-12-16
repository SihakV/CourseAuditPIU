@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="card" style="margin:20px;">
            <div class="card-header">
                <h3>Add/Remove course to the Study Plan</h3>
            </div>
            <br />
            <div class="card-body">
                <a href="{{ url('/admin/studyplans/' . $studyplans->id . '/view/list') }}" class="btn btn-success btn-sm">
                    Add Course
                </a>
            </div>
            <br />

            @foreach ($semester as $sem)
                <h5>Semester {{ $sem }}</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Course Name</th>
                            <th>Credit</th>
                            <th>Type(s)</th>
                            <th>Action</th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courseGroups[$sem] ?? [] as $course)
                            <tr>
                                <td style="width: 50px">{{ $course->code_name }}</td>
                                <td style="width: 140px">{{ $course->name }}</td>
                                <td style="width: 30px">{{ $course->credit }}</td>
                                <td style="width: 120px">
                                    @foreach ($course->types as $type)
                                        {{ $type->name }}
                                        @if (!$loop->last)
                                            /
                                        @endif
                                    @endforeach
                                </td>
                                <td style="width: 100px">
                                    <form method="POST"
                                        action="{{ url('/admin/studyplans/' . $studyplans->id . '/courses/' . $course->id) }}"
                                        accept-charset="UTF-8" style="display:inline">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        <button type="submit" onclick="return confirm("Confirm delete?")
                                            class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                </table>
                <br />
            @endforeach



        </div>
    </div>
@endsection
