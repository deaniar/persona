@extends('layouts.auth-master')
@section('content')
    <div class="account-page">
        <div class="account-center">
            <div class="account-box">
                <form action="{{ route('password.update') }}" class="form-signin" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $token }}" name="token">
                    <input type="hidden" value="{{ $email }}" name="email">
                    <div class="account-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo-persona.svg') }}"
                                alt="logo-persona"></a>
                    </div>
                    @include('layouts.flash-alert')
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" autofocus="" class="form-control" name="password">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary account-btn">Set New Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
