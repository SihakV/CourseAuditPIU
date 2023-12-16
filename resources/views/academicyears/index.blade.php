@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Academic Years</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/academicyears') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                Add New Year
                            </button>
                        </form>

                    </div>
                    <br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Study Plan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academicyears as $item)
                                    <tr>

                                        <td>{{ $item->year }}</td>
                                        <td>{{ $item->studyPlan?->name ?? '-' }}</td>

                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
