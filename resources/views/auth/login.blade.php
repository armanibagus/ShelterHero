@extends('layouts.app')

@section('content')
<div class="card-body">
    <p class="login-box-msg text-gray-dark h2 text-bold" style="padding: 0 20px 0">Welcome</p>
    <p class="login-box-msg text-gray text-s">Already have an account?</p>

    {{-- User input --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- input username --}}
        <div class="col-12 mb-2">
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" required autocomplete="username" placeholder="Username or Email" autofocus>

            @error('username')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>

        {{-- input password --}}
        <div class="col-12 mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="col-8">
            <div class="icheck-primary">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>

        {{-- login button --}}
        <div class="col-12 mb-3">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Log in') }}
            </button>
        </div>
        @if(session()->has('error'))
            <p class="login-box-msg text-danger">{{ session()->get('error') }}</p>
        @endif
        <p class="text-gray text-center text-sm" style="margin: 20px 0 10px">- OR -</p>

        {{--<hr class="my-3">
            <p class="text-gray text-center">OR</p>
        <hr class="my-3">--}}
        <div class="text-center text-sm">
            <a class="text-gray">
                Don't have an account?
            </a>
            <a class="text-primary" href="{{ route('register') }}">
                {{ __('Register') }}
            </a>
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </form>
</div>
<!-- /.card-body -->
@endsection
