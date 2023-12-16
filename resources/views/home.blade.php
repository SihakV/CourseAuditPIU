@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                @auth
                    @if(auth()->user()->isAdmin())
                        Hello, {{ auth()->user()->name }}! You are an admin. <a href={{url('/admin/users')}}>Users</a>
                    @else
                        Hi, {{ auth()->user()->name }}! You're a normal user.
                    @endif
                @endauth

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
