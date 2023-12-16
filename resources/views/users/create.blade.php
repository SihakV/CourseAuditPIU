@extends('layouts.admin')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Create New Student</div>
        <div class="card-body">
            <form action="{{ url('/admin/users/') }}" method="post">
                @csrf
                <label>Name</label><br />
                <input required type="text" name="name" id="name" class="form-control"><br />
                <label>Email</label><br />
                <input required type="email" name="email" id="email" class="form-control"><br />
                <label>Password</label><br />
                <input required type="password" name="password" id="password" class="form-control"><br />

                <select required name="year_level" id="year_level" aria-label="Default select example">
                    <option selected value="">Year Level</option>
                    @foreach ($year_level as $level)
                        <option value="{{ $level }}">{{ $level }}</option>
                    @endforeach
                </select>

                <select required name="academic_year_id" id="academic_year_id" aria-label="Default select example">
                    <option selected value="">Academic Year</option>
                    @foreach ($academicyears as $year)
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>
                <br /><br />
                <input type="submit" value="Save" class="btn btn-success"><br />
            </form>

        </div>
    @endsection
