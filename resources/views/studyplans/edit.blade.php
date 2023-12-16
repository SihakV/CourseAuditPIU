@extends('layouts.admin')
@section('content')
    <div class="card" style="margin: 20px;">
        <div class="card-header">Edit Requirements</div>
        <div class="card-body">
            <form action="{{ url('/admin/studyplans/' . $studyplans->id) }}" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" id="id" value="{{ $studyplans->id }}" id="id" />
                <label>Name</label></br>
                <input required type="text" name="name" id="name" value="{{ $studyplans->name }}"
                    class="form-control"></br>
                @foreach ($types as $type)
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label col-form-label-sm">{{ $type->name }}</label>
                        <div class="col-sm-10">
                            <input id="{{ $type->id }}" name="requirements[{{ $type->id }}]"
                                value="{{ $requirements->where('type_id', $type->id)->first()?->min_course }}"
                                type="number" class="form-control form-control-sm">
                        </div>
                    </div>
                @endforeach
                <input type="submit" value="Update" class="btn btn-success"></br>
            </form>
        @endsection
