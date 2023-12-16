@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Promote Students</h2>
                    </div>
                    @error('students')
                        <small> please select student(s)</small>
                    @enderror
                    <br />
                    <form action='{{ url('/admin/users/promote') }}'>
                        @csrf
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
                    <form action="{{ url('admin/users/promote') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>select</th>

                                        <th>Name</th>
                                        <th>Year Level</th>
                                        <th>Year</th>
                                        <th>email</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td><input class="form-check-input" style="margin:10px;" type="checkbox"
                                                    name="students[]" value="{{ $item->id }}" />
                                                <label class="form-check-label" id="">
                                                    <p></p>
                                                </label>
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->year_level }}</td>
                                            <td>{{ $item->academicYear->year }}</td>
                                            <td>{{ $item->email }}</td>

                                        </tr>
                                    @endforeach
                            </table>
                            <input type="submit" value="Save" class="btn btn-success"><br />
                    </form>
                </div>
            </div>
        </div>
    </div>\
@endsection
