@extends('layouts.admin')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Assign to Students</div>
        <div class="card-body">
            @error('students')
                <small>select student(s) to continue</small>
            @enderror
            <form action='{{ url('/admin/studyplans/' . $studyplan->id . '/assignStudent') }}'>
                <div class="input-group mb-3" style="padding-left: 10px; width: 50%;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </span>
                    </div>
                    <input type="search" name='search' class="form-control" placeholder="search...">
                    <button type="submit" class="btn btn-light">Search</button>
                </div>
            </form>
            <form action="{{ url('/admin/studyplans/' . $studyplan->id . '/assignStudent') }}" method="POST">
                @csrf
                @foreach ($students as $student)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->id }}"
                            id="{{ $student->id }}">
                        <label class="form-check-label" id="{{ $student->id }}">
                            <p>{{ $student->name }}</p>
                        </label>
                    </div>
                @endforeach
                <input type="submit" value="Save" class="btn btn-success"><br />
            </form>

        </div>
    @endsection
