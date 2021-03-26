@extends('layouts.auth-master')
@section('content')
    <div class="account-page">
        <div class="account-center">
            <div class="account-box">
                <form action="{{ route('forgot-password') }}" class="form-signin" method="POST">
                    @csrf
                    <div class="account-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo-persona.svg') }}"
                                alt="logo-persona"></a>
                    </div>
                    @include('layouts.flash-alert')
                    <div class="form-group">
                        <label>Enter Your Email</label>
                        <input type="text" autofocus="" class="form-control" name="email">
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary account-btn">Reset Password</button>
                    </div>
                    <div class="text-center register-link">
                        <a href="{{ route('login') }}">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
