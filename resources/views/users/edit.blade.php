@extends('layouts.admin')
@section('content')
    <div class="card" style="margin: 20px;">
        <div class="card-header">Edit Student</div>
        <div class="card-body">
            <form action="{{ url('/admin/users/' . $users->id) }}" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="id" value="{{ $users->id }}" id="id" />
                <label>Name</label><br />
                <input required type="text" name="name" id="name" value="{{ $users->name }}"
                    class="form-control"><br />
                <label>Email</label><br />
                <input required type="email" name="email" id="email" value="{{ $users->email }}"
                    class="form-control"></br>
                <label>Password</label><br />
                <input type="password" name="password" id="password" value="" class="form-control"></br>

                <p>{{ $users->year_level }}</p>
                <select required name="year_level" id="year_level" aria-label="Default select example">
                    <option {{ $users->year_level ? '' : 'selected' }} value=''>Year Level</option>
                    @foreach ($year_level as $level)
                        <option value="{{ $level }}" {{ $users->year_level == $level ? 'selected' : '' }}>
                            {{ $level }}</option>
                    @endforeach
                </select>

                <select required name="academic_year_id" id="academic_year_id" aria-label="Default select example">
                    <option {{ $users->academic_year_id ? '' : 'selected' }} value=''>Academic Year</option>
                    @foreach ($academicyears as $year)
                        <option value="{{ $year->id }}" {{ $users->academic_year_id == $year->id ? 'selected' : '' }}>
                            {{ $year->year }}</option>
                    @endforeach
                </select>
                <br /><br />
                <input type="submit" value="Update" class="btn btn-success"></br>
            </form>
        @endsection
