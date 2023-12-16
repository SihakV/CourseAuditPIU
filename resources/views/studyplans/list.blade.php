@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Courses</h2>
                    </div>
                    @error('courses')
                        <small> please select a course</small>
                    @enderror
                    <br />

                    <form action='{{ url('/admin/studyplans/' . $studyplans->id . '/view/list') }}'>
                        <div class="input-group mb-3" style="padding-left: 10px; width: 50%;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </span>
                            </div>
                            <input type="search" name='search' class="form-control" placeholder="search...">
                            <button type="submit" class="btn btn-light">Search</button>
                        </div>
                    </form>
                    <form action="{{ url('/admin/studyplans/' . $studyplans->id . '/view/list') }}" method="POST">
                        @csrf
                        <p>Add to Semester
                            <select name="semester" required id="semester" aria-label="Default select example">
                                <option value="" selected>Semester</option>
                                @foreach ($semester as $sem)
                                    <option value="{{ $sem }}">{{ $sem }}</option>
                                @endforeach
                            </select>
                        </p><br />


                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Name</th>
                                        <th>Code Name</th>
                                        <th>Credit</th>
                                        <th>Types</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($courses as $item)
                                        <tr>
                                            <td>
                                                <input class="form-check-input" style="margin:10px;" type="checkbox"
                                                    name="courses[]" value="{{ $item->id }}"
                                                    id="couses-{{ $item->id }}" />
                                                <label class="form-check-label" id="">
                                                    <p></p>
                                                </label>
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->code_name }}</td>
                                            <td>{{ $item->credit }}</td>
                                            <td>
                                                @foreach ($item->types as $type)
                                                    {{ $type->name }}
                                                @endforeach
                                            </td>

                                        </tr>
                                    @endforeach

                            </table>
                            <input type="submit" value="Save" class="btn btn-success"><br />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
