@extends('layouts.app')

@section('content')
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
        <p class="login-box-msg text-gray-dark h4 text-bold mb-2" style="padding: 0 20px 0">Forgot Your Password?</p>
        <p class="login-box-msg text-gray text-sm mb-2">Enter your email, and we'll send you a link to reset your password.</p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
{{--            <label for="email" class="col-md-5 col-form-label">{{ __('E-Mail Address') }}</label>--}}

            <div class="col-md-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email address" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="mb-2">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
