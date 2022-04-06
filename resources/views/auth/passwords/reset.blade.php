@extends('layouts.app')

@section('content')

<div class="card-body">
    <p class="login-box-msg text-gray-dark h4 text-bold mb-2" style="padding: 0 20px 0">Reset Password</p>
    <p class="login-box-msg text-gray text-sm" style="padding: 0 10px 0">Enter your new password below.</p>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
{{--            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

            <div class="col-md-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Enter email address" required autocomplete="email" readonly hidden>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
{{--            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>--}}
            <div class="col-md-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter new password" required autocomplete="new-password"  autofocus>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
{{--            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

            <div class="col-md-12">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" required autocomplete="new-password">
            </div>
        </div>

        <div class="mb-2">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
