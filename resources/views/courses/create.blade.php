@extends('layouts.admin')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Create New Courses</div>
        <div class="card-body">
            @error('types')
                <small>select type to continue</small>
            @enderror
            <form action="{{ url('/admin/courses/') }}" method="post">
                @csrf
                <label>Name</label><br />
                <input required type="text" name="name" id="name" class="form-control"><br />
                <label>Code Name</label><br />
                <input required type="text" name="code_name" id="code_name" class="form-control"><br />
                <label>Credit</label><br />
                <input required type="number" name="credit" id="credit" class="form-control"><br />
                @foreach ($types as $type)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="types[]" value="{{ $type->id }}"
                            id="{{ $type->id }}">
                        <label class="form-check-label" id="{{ $type->id }}">
                            <p>{{ $type->name }}</p>
                        </label>
                    </div>
                @endforeach
                <input type="submit" value="Save" class="btn btn-success"><br />


            </form>

        </div>
    @endsection
