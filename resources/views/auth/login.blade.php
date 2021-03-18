@extends('layouts.auth-master')
@section('content')
    <div class="account-page">
        <div class="account-center">
            <div class="account-box">
                <form action="{{ url('login') }}" class="form-signin" method="POST">
                    @csrf
                    <div class="account-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo-persona.svg') }}"
                                alt="logo-persona"></a>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" autofocus="" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group text-right">
                        <a href="forgot-password.html">Forgot your password?</a>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary account-btn">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
