@extends('layouts.admin')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Create New Study Plan</div>
        <div class="card-body">
            <form action="{{ url('/admin/studyplans/') }}" method="post">
                @csrf
                <label>Name</label><br />
                <input required type="text" name="name" id="name" class="form-control"><br />
                <label>Requirements:</label><br /> <br />
                @foreach ($types as $type)
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-sm">{{ $type->name }}</label>
                        <div class="col-sm-10">
                            <input id="{{ $type->id }}" name="requirements[{{ $type->id }}]" type="number"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                @endforeach
                <input type="submit" value="Save" class="btn btn-success"><br />
            </form>

        </div>
    @endsection
