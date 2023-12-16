@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Study Plan</h2>
                    </div>
                    <div class="card-body">
                        <a href="{{ url('/admin/studyplans/create') }}" class="btn btn-success btn-sm" title="Add New Student">
                            Add New Study Plan
                        </a>
                    </div>
                    <br />
                    <form action='{{ url('/admin/studyplans') }}'>
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
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studyplans as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ url('/admin/studyplans/' . $item->id . '/assign') }}"><button
                                                    type="button" class="btn btn-info">Assign</button></a>
                                            <a href="{{ url('/admin/studyplans/' . $item->id . '/edit') }}"
                                                title="Edit studyplan"><button type="button"
                                                    class="btn btn-primary">Edit</button></a>
                                            <a href="{{ url('/admin/studyplans/' . $item->id . '/unassign') }}"><button
                                                    type="button" class="btn btn-warning">Unassign</button></a>
                                            <a href="{{ url('/admin/studyplans/' . $item->id . '/view') }}"><button
                                                    type="button" class="btn btn-warning">Edit Plan</button></a>
                                            <a href="{{ url('/admin/studyplans/' . $item->id . '/assignStudent') }}"><button
                                                    type="button" class="btn btn-info">Assign to Student</button></a>

                                            <form method="POST" action="{{ url('/admin/studyplans/' . $item->id) }}"
                                                accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                @csrf
                                                <button type="submit" title="Delete studyplan"
                                                    onclick="return confirm("Confirm delete?")
                                                    class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
