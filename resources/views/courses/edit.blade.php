@extends('layouts.admin')
@section('content')
    <div class="card" style="margin: 20px;">
        <div class="card-header">Edit Course</div>
        <div class="card-body">
            @error('types')
                <small>select type to continue</small>
            @enderror
            <form action="{{ url('/admin/courses/' . $courses->id) }}" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="id" value="{{ $courses->id }}" id="id" />
                <label>Name</label><br />
                <input required type="text" name="name" id="name" value="{{ $courses->name }}"
                    class="form-control"><br />
                <label>Code Name</label><br />
                <input required type="text" name="code_name" id="code_name" value="{{ $courses->code_name }}"
                    class="form-control"><br />
                <label>Credit</label><br />
                <input required type="number" name="credit" id="credit" value="{{ $courses->credit }}"
                    class="form-control"><br />
                @foreach ($types as $type)
                    <div class="form-check">
                        @php
                            $checked = $courses->types->where('id', $type->id)->isNotEmpty();
                        @endphp
                        <input class="form-check-input" type="checkbox" name="types[]" value="{{ $type->id }}"
                            {{ $checked ? 'checked' : '' }} id="{{ $type->id }}">
                        <label class="form-check-label" id="{{ $type->id }}">
                            <p>{{ $type->name }}</p>
                        </label>
                    </div>
                @endforeach
                <input type="submit" value="Update" class="btn btn-success"><br />
            </form>
        @endsection
