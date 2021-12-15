@extends('layouts.app')

@section('content')

<style>
    #hidden_div {
        display: none;
    }
</style>

<div class="card-body">
    <p class="login-box-msg h3" style="padding: 0 0 5px">
        <strong>CREATE ACCOUNT</strong>
    </p> <p class="login-box-msg">Become a part of us and gain access to exclusive features.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{-- Select Form --}}
        <div class="form-group">
            <select type="text" class="form-control @error('role') is-invalid @enderror" required id="role" name="role" onchange="showDiv(this)">
                <option selected disabled value="" class="text-center"> ---[Register as]--- </option>
                <option value="user">User</option>
                <option value="volunteer">Volunteer</option>
                <option value="pet_shelter">Pet Shelter</option>
            </select>
        </div>
        <hr class="my-3">

        {{-- Identity Number Form --}}
        <div class="form-group">
            <label id="identityLabel" class="mb-1">Identity Number</label>
            <input id="identityNumber" type="text" class="form-control @error('identityNumber') is-invalid @enderror" name="identityNumber" placeholder="Enter identity number" value="{{ old('identityNumber') }}" required autocomplete="identityNumber">

            @error('identityNumber')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        {{-- Name Form --}}
        <div class="form-group">
            <label class="mb-1">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter full name" value="{{ old('name') }}" required autocomplete="name">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- Date of Birth --}}
        <div id="hidden_div" class="form-group">
            <label class="mb-1">Date of Birth</label>
            <div class="form-group mb-2">
                <input id="dateOfBirth" type="date" class="form-control @error('dateOfBirth') is-invalid @enderror" name="dateOfBirth" autocomplete="dateOfBirth">

                @error('dateOfBirth')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        {{-- Phone Number Form --}}
        <div class="form-group">
            <label class="mb-1">Phone Number</label>
            <input id="phoneNumber" type="text" class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber" placeholder="Enter phone number" value="{{ old('phoneNumber') }}" required autocomplete="phoneNumber">

            @error('phoneNumber')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        {{-- Address Form --}}
        <div class="form-group">
            <label class="mb-1">Address</label>
            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter address" value="{{ old('address') }}" required autocomplete="address">

            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        {{-- Email Form --}}
        <div class="form-group">
            <label class="mb-1">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email address" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>

        {{-- Username Form --}}
        <div class="form-group">
            <label class="mb-1">Username</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Enter username" value="{{ old('username') }}" required autocomplete="username">

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>

        {{-- Password Form --}}
        <div class="form-group">
            <label class="mb-1">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
        </div>

        {{-- Confirm Password Form --}}
        <div class="form-group">
            <label class="mb-1">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required autocomplete="new-password">

        </div>

        {{-- Register button --}}
        <div class="input-group mb-3">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Register') }}
                </button>
        </div>
    </form>

    {{-- login link --}}
    <div class="text-center text-sm">
        <a class="text-gray">
            Already have an account?
        </a>
        <a class="text-primary" href="{{ route('login') }}">
            {{ __('Log in') }}
        </a>
    </div>
</div>
<script>
    function showDiv(select)
    {
        if (select.value === 'user') {
            document.getElementById('identityNumber').setAttribute("placeholder", "Enter identity number");
            document.getElementById('name').setAttribute("placeholder", "Enter full name");
            document.getElementById('identityLabel').innerHTML = "Identity Number";
            document.getElementById('hidden_div').style.display = "block";
        }
        else {
            if (select.value === 'volunteer' ){
                document.getElementById('identityNumber').setAttribute("placeholder", "Enter medical license number");
                document.getElementById('name').setAttribute("placeholder", "Enter full name");
                document.getElementById('identityLabel').innerHTML = "Medical License Number";
            }
            else if (select.value === 'pet_shelter' ){
                document.getElementById('identityNumber').setAttribute("placeholder", "Enter shelter license number");
                document.getElementById('name').setAttribute("placeholder", "Enter pet shelter name");
                document.getElementById('identityLabel').innerHTML = "Shelter License Number";
            }
            document.getElementById('hidden_div').style.display = "none";
        }
    }
</script>
@endsection
