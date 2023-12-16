@extends('layouts.student')
@section('content')
    <div class="container" style="width:fit-content">
        <div class="row" style="margin:20px;">
            <div class="col-md-12">
                <div class="card border border-0">
                    <div class="card-header">
                        <h2>Welcome {{ $user->name }}</h2>
                    </div>
                    @if (!$studyplan)
                        <p>No Study Plan Assigned</p>
                    @endif
                    @if ($studyplan)
                        <div class="card-header" style="width:fit-content">
                            @php
                                $reqs = $user->getUserCourseRequirements();
                            @endphp
                            <h6 style="padding: 10px;">Note: Core, Math, F-MathSciTech, and F-Core courses will be marked
                                as
                                incomplete and needs to be
                                retaken to complete if the grade is DD or F.</h6><br />
                            <h6> Incomplete courses:</h6>
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Code</th>
                                        <th>Course Name</th>
                                        <th>Type(s)</th>
                                    </tr>
                                </thead>
                                @foreach ($user->getFailedCourses() as $fail)
                                    <tr>
                                        <td>{{ $fail->code_name }}</td>
                                        <td>{{ $fail->name }}</td>

                                        <td>
                                            @foreach ($fail->types as $type)
                                                {{ $type->name }}
                                                @if (!$loop->last)
                                                    /
                                                @endif
                                            @endforeach
                                        </td>
                                @endforeach
                                </tr>

                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Minimum Requirements</th>
                                            <th>Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reqs as $req)
                                            @if ($req->type->name == 'DE' || $req->type->name == 'GE')
                                                @if ($req->type->name == 'DE')
                                                    <tr>
                                                        <td>Department Elective ({{ $req->type->name }})</td>
                                                        <td>{{ $req->min_course }}</td>
                                                        <td>{{ $req->num_of_courses_fulfilled }}</td>
                                                    </tr>
                                                @endif
                                                @if ($req->type->name == 'GE')
                                                    <tr>
                                                        <td>General Elective ({{ $req->type->name }})</td>
                                                        <td>{{ $req->min_course }}</td>
                                                        <td>{{ $req->num_of_courses_fulfilled }}</td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td>{{ $req->type->name }}</td>
                                                    <td>{{ $req->min_course }}</td>
                                                    <td>{{ $req->num_of_courses_fulfilled }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td><b>Credits:</b></td>
                                            <td><b>132 </b></td>
                                            <td><b>{{ $user->getUserCredit() }}</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>CGPA</b></td>
                                            <td><b>2.0</b></td>
                                            <td><b>{{ $user->getCGPA() }}</b></td>
                                        </tr>
                                </table>
                        </div><br />
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
