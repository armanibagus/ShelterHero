@extends('template')

@section('page-title')
    {{__('Profile')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(Auth::user()->photo_title != NULL && Auth::user()->photo_path != NULL)
                                    @php
                                        $title = trim(str_replace("public/profile-picture/","", Auth::user()->photo_path));
                                    @endphp
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 100px; width: 100px; object-fit: cover;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                @endif
                            </div>
                            <div class="profile-username text-center"><strong>{{__($user->name)}}</strong> <i class="fas fa-check-circle text-primary text-sm "></i></div>
                            <p class="text-muted text-center">
                                @if($user->role == 'pet_shelter')
                                    {{__('Pet Shelter')}}
                                @elseif($user->role == 'volunteer')
                                    {{__('Volunteer')}}
                                @elseif($user->role == 'user')
                                    {{__('User')}}
                                @endif
                            </p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    @if($user->role == 'volunteer' || $user->role == 'pet_shelter')
                                    <strong>License</strong> <span class="text-muted float-right">{{__($user->identityNumber)}}</span>
                                    @elseif($user->role == 'user')
                                    <strong>ID Number</strong> <span class="text-muted float-right">{{__($user->identityNumber)}}</span>
                                    @endif
                                </li>
                                <li class="list-group-item">
                                    <strong>Username</strong> <span class="text-muted float-right">{{__($user->username)}}</span>
                                </li>
                                @if($user->role == 'user')
                                <li class="list-group-item">
                                    <strong>Date of Birth</strong> <span class="text-muted float-right">{{__(date('d M Y',strtotime($user->dateOfBirth)))}}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Contact</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-phone-square-alt mr-1"></i> Phone Number</strong>
                            <p class="text-muted">{{__($user->phoneNumber)}}</p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email Address</strong>
                            <p class="text-muted">{{__($user->email)}}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">{{__($user->address)}} </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-edit"></i> Edit Profile</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-2">
                                @if(Auth::user()->photo_title != NULL && Auth::user()->photo_path != NULL)
                                @php
                                    $title = trim(str_replace("public/profile-picture/","", Auth::user()->photo_path));
                                @endphp
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 100px; width: 100px; object-fit: cover;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                @endif
                            </div>
                            <form method="POST" action="{{ route('users.update', Auth::user()->id) }}" accept-charset="utf-8" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group text-center mb-4">
                                    <label class="btn btn-link p-0 m-0 align-baseline" for="profile-photo">
                                        <input id="profile-photo" type="file" name="profile_picture" class="d-none custom-file-input @error('profile_picture') is-invalid @enderror">
                                        Change Profile Photo
                                        @error('profile_picture')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </label>
                                    <button type="submit" id="profile-photo-submit" hidden>Upload Photo</button>
                                </div>
                            </form>
                            <form class="form-horizontal" method="POST" action="{{ route('users.update', Auth::user()->id) }}">
                                @csrf
                                @method('PUT')
                                @php
                                    if(Auth::user()->role == 'user') {
                                      $idNumLabel = 'Identity Number';
                                      $placeholder = 'identity number';
                                      $phName = 'full name';
                                    }
                                    else if(Auth::user()->role == 'volunteer') {
                                      $idNumLabel = 'Medical License';
                                      $placeholder = 'medical license number';
                                      $phName = 'full name';
                                    }
                                    else if(Auth::user()->role == 'pet_shelter') {
                                      $idNumLabel = 'Shelter License';
                                      $placeholder = 'shelter license number';
                                      $phName = 'pet shelter name';
                                    }
                                @endphp
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">{{ __($idNumLabel) }}</label>
                                    <div class="col-sm-10">
                                        <input id="identityNumber" type="text" class="form-control @error('identityNumber') is-invalid @enderror" name="identityNumber" placeholder="Enter {{ __($placeholder) }}" value="{{ Session::has('errors') ? old('identityNumber') : Auth::user()->identityNumber }}" required @error('identityNumber') autofocus @enderror autocomplete="identityNumber">
                                        @error('identityNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted">{{ __($idNumLabel) }} help us identify your identity to prevent criminal activity.</small>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter {{ __($phName) }}" value="{{ Auth::user()->name }}" required @error('name') autofocus @enderror autocomplete="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small class="text-muted">Help people discover your accounts using the name you're known by: either nicknames, full name, or pet shelter name.</small>
                                    </div>
                                </div>
                                @if(Auth::user()->role == 'user')
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Date of Birth</label>
                                    <div class="col-sm-10">
                                        <input id="dateOfBirth" type="date" class="form-control @error('dateOfBirth') is-invalid @enderror" name="dateOfBirth" value="{{ date('Y-m-d',strtotime(Auth::user()->dateOfBirth)) }}" required @error('dateOfBirth') autofocus @enderror autocomplete="bday">
                                        @error('dateOfBirth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <br>
                                <div class="offset-sm-2 col-sm-10">
                                    <p class="text-muted">
                                        <strong>Personal Information</strong><br>
                                        <small>Provide your personal information to authenticate your account.</small>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Enter username" value="{{ Session::has('errors') ? old('username') : Auth::user()->username }}" required @error('username') autofocus @enderror autocomplete="">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email Address</label>
                                    <div class="col-sm-10">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email address" value="{{ Session::has('errors') ? old('email') : Auth::user()->email }}" required @error('email') autofocus @enderror autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        @if(Auth::user()->email_verified_at == NULL)
                                            <small class="text-muted">
                                                <button type="button" class="btn btn-link p-0 m-0 align-baseline text-sm" data-toggle="modal" data-target="#modal-email-confirm">
                                                    Confirm Email Address
                                                </button>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Phone Number</label>
                                    <div class="col-sm-10">
                                        <input id="phoneNumber" type="tel" class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber" placeholder="Enter phone number" value="{{ Session::has('errors') ? old('phoneNumber') : Auth::user()->phoneNumber }}" required @error('phoneNumber') autofocus @enderror autocomplete="phone">
                                        @error('phoneNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter address" value="{{ Auth::user()->address }}" required @error('address') autofocus @enderror autocomplete="street-address">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="offset-sm-2 col-sm-10">
                                    <p class="text-muted">
                                        <strong >Change Password</strong><br>
                                        <small>If necessary, change your password periodically, in order to increase the security of your account. If you don't want to change your password, leave all the fields below blank.</small>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Old Password</label>
                                    <div class="col-sm-10">
                                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="Enter old password" value="{{ Session::has('errors') ? old('old_password') : '' }}" @error('old_password') autofocus @enderror autocomplete="current-password">
                                        @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter new password" value="{{ Session::has('errors') ? old('password') : '' }}" @error('password') autofocus @enderror autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Confirm New Password</label>
                                    <div class="col-sm-10">
                                        <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Retype new password" @error('password_confirmation') autofocus @enderror autocomplete="new-password">
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-email-confirm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Verify Your Email Address') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        Follow the link in the email we sent {{Auth::user()->email}} to verify your email address and help secure your account.
                        If you did not receive the email,
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button id="verification-button" type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
</div>
@endsection
