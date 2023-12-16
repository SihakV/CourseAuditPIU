@extends('layouts.admin')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Assign to Academic year</div>
        <div class="card-body">
            @error('years')
                <small>select year(s) to continue</small>
            @enderror
            <form action="{{ url('/admin/studyplans/' . $studyplan->id . '/assign') }}" method="POST">
                @csrf
                @foreach ($years as $year)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="years[]" value="{{ $year->id }}"
                            id="{{ $year->id }}">
                        <label class="form-check-label" id="{{ $year->id }}">
                            <p>{{ $year->year }}</p>
                        </label>
                    </div>
                @endforeach
                <input type="submit" value="Save" class="btn btn-success"><br />
            </form>

        </div>
    @endsection
