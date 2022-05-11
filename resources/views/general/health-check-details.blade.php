@extends('template')

@section('page-title')
    {{__('Request Volunteer Details')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Request Volunteer Details')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Request::is('health-checks/*') && Auth::user()->role == 'pet_shelter')
                        <li class="breadcrumb-item"><a href="{{url('/pet-shelter/home')}}">Main Menu</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Request Volunteer</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('users.show', $healthCheck->volunteer_id)}}">Volunteer Details</a></li>
                        <li class="breadcrumb-item active">{{__('Request Volunteer Details')}}</li>
                        @elseif((Request::is('health-checks/*/edit') || Request::is('health-checks/*')) && Auth::user()->role == 'volunteer')
                        <li class="breadcrumb-item"><a href="{{url('/volunteer/home')}}">Main Menu</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/health-checks')}}">Pet Medical Checkup</a></li>
                        <li class="breadcrumb-item active">{{__('Request Volunteer Details')}}</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-8" style="margin: auto">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="display: block; margin: auto; width: 30%" alt="logo image">
                        <br>
                        <div class="card-header">
                            <h2 class="card-title text-bold text-lg text-center" style="float: none">{{__('Request Volunteer Details')}}</h2>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5><strong>Pet Shelter</strong></h5><br>
                                    <a href="{{ route('users.show', $pet_shelter->id) }}" style="color: #000">
                                        @if($pet_shelter->photo_title != NULL && $pet_shelter->photo_path != NULL)
                                            @php
                                                $title = trim(str_replace("public/profile-picture/","", $pet_shelter->photo_path));
                                            @endphp
                                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 100px; width: 100px; object-fit: cover;">
                                        @else
                                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                        @endif
                                        <p>
                                            <strong>{{ __($pet_shelter->name) }}</strong>
                                        </p>
                                    </a>
                                    <p>
                                        Shelter License {{ __($pet_shelter->identityNumber) }}
                                    </p>
                                </div>
                                <hr>
                                <h5 class="text-center"><strong>Pet Information</strong></h5><br>
                                <div class="row mb-3 justify-content-center">
                                    <div class="col-md-5 align-self-center mr-4">
                                        @php
                                            $image = DB::table('images')->where('pet_id', '=', $pet->id)->first();
                                            $title = trim(str_replace("public/images/","", $image->path));
                                        @endphp
                                        <img src="{{ asset('storage/images/'.$title) }}" class="product-image" alt="Pet Image" style="object-fit: cover;">
                                    </div>
                                    <div class="col-md-3">
                                        <h6><strong>Nickname</strong></h6>
                                        <p>
                                            {{ __($pet->nickname) }}
                                        </p>
{{--                                        <hr>--}}
                                        <h6><strong>Age</strong></h6>
                                        <p>
                                            {{ __($pet->age) }}
                                        </p>
{{--                                        <hr>--}}
                                        <h6><strong>Breed</strong></h6>
                                        <p>
                                            {{ __($pet->petType) }}
                                        </p>
{{--                                        <hr>--}}
                                    </div>
                                    <div class="col-md-3">
                                        <h6><strong>Gender/Sex</strong></h6>
                                        <p>
                                            {{ __($pet->sex) }}
                                            @if($pet->sex === 'Male')
                                                <i class="nav-icon text-blue fas fa-mars"></i>
                                            @elseif($pet->sex === 'Female')
                                                <i class="nav-icon text-pink fas fa-venus"></i>
                                            @endif
                                        </p>
{{--                                        <hr>--}}
                                        <h6><strong>Size</strong></h6>
                                        <p>
                                        {{ __($pet->size) }}
                                        </p>
{{--                                        <hr>--}}
                                        <h6><strong>Weight</strong></h6>
                                        <p>
                                            {{ __($pet->weight) }} Kg
                                        </p>
{{--                                        <hr>--}}
                                    </div>
                                </div>
                                <hr>
                                <h6><strong>Request ID</strong></h6>
                                <p>
                                    {{ __($healthCheck->id) }}
                                </p>
                                <hr>
                                <h6><strong>Proposed Checkup Date</strong></h6>
                                <p>
                                    {{ \Carbon\Carbon::parse($healthCheck->checkup_date)->isoFormat('DD MMMM YYYY') }}
                                </p>
                                <hr>
                                <h6><strong>Description</strong></h6>
                                <p>
                                    {{ __($healthCheck->description) }}
                                </p>
                                <hr>
                                @if(Request::is('health-checks/*/edit') && Auth::user()->role == 'volunteer' && $healthCheck->status == 'Pending')
                                    <form method="POST" action="{{ route('health-checks.update', $healthCheck->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select id="status" type="text" name="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option selected disabled value="" >---[Select one]---</option>
                                                <option value="{{ Crypt::encrypt('Accepted') }}">Accepted</option>
                                                <option value="{{ Crypt::encrypt('Rejected') }}">Rejected</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label id="feedbackLabel" for="feedback" class="mb-1">Feedback</label>
                                            <div class="input-group">
                                                <textarea id="feedback" type="text" class="form-control @error('feedback') is-invalid @enderror" name="feedback" placeholder="Type here..." required rows="4">{{ old('feedback') }}</textarea>

                                                @error('feedback')
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block float-right mt-2">
                                            {{ __('Submit') }}
                                        </button>
                                    </form>
                                @else
                                    <h6><strong>Status</strong></h6>
                                        @if($healthCheck->status == 'Accepted')
                                        <p class="text-success"><strong><i class="fas fa-check-circle fa-lg mr-2"></i>{{ __($healthCheck->status) }}</strong></p>
                                        @elseif($healthCheck->status == 'Pending')
                                        <p class="text-gray"><strong> <i class="fas fa-spinner fa-lg mr-2"></i> {{ __($healthCheck->status) }}</strong></p>
                                        @elseif($healthCheck->status == 'Rejected')
                                        <p class="text-danger"><strong><i class="fas fa-times fa-lg mr-2"></i>{{ __($healthCheck->status) }}</strong></p>
                                        @endif
                                    <hr>
                                    <h6><strong>Feedback</strong></h6>
                                    <p>
                                        @if($healthCheck->feedback == NULL)
                                        {{ __('-') }}
                                        @else
                                        {{ __($healthCheck->feedback) }}
                                        @endif
                                    </p>
                                    <hr>
                                    @if(Request::is('health-checks/*') && $healthCheck->status == 'Accepted')
                                        @if($medical_reports == NULL && Auth::user()->role == 'volunteer')
                                            <form method="GET" action="{{ route('medical-reports.create') }}">
                                                <input id="health_check_id" type="number" name="health_check_id" value="{{$healthCheck->id}}" hidden readonly>
                                                <button type="submit" class="btn btn-block btn-success"><i class="fas fa-notes-medical text-lg mr-2"></i>Create Medical Report</button>
                                            </form>
                                        @else
                                        <h4 class="text-center"><strong>Medical Report</strong></h4><br>
                                        <div class="row justify-content-center">
                                            <div class="col-md-6" style="border-left: 0.25rem solid #000">
                                                <h6><strong>Allergies</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->allergies) }}
                                                </p>
                                                <hr>
                                                <h6><strong>Existing Condition</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->existing_condition) }}
                                                </p>
                                                <hr>
                                                <h6><strong>Vaccination</strong></h6>
                                                <p>
                                                    @if($medical_reports->vaccination != NULL)
                                                        {{ ($medical_reports->vaccination) }}
                                                    @else
                                                        {{ __('-') }}
                                                    @endif
                                                </p>
                                                <hr>
                                                <h6><strong>Diagnosis</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->diagnosis) }}
                                                </p>
                                                <hr style="margin-bottom: 0!important;">
                                            </div>
                                            <div class="col-md-6" style="border-left: 0.25rem solid #000">
                                                <h6><strong>Test Performed</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->test_performed) }}
                                                </p>
                                                <hr>
                                                <h6><strong>Test Result</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->test_result) }}
                                                </p>
                                                <hr>
                                                <h6><strong>Action</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->action) }}
                                                </p>
                                                <hr>
                                                <h6><strong>Medication</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->medication) }}
                                                </p>
                                                <hr style="margin-bottom: 0!important;">
                                            </div>
                                            <div class="col-md-12 mb-3 pt-3" style="border-left: 0.25rem solid #000">
                                                <h6><strong>Comments</strong></h6>
                                                <p>
                                                    {{ ($medical_reports->comments) }}
                                                </p>
                                                <hr style="margin-bottom: 0!important;">
                                            </div>
                                        </div>
                                            @if(Auth::user()->role == 'volunteer')
                                            <a class="btn btn-block btn-success" href="{{ route('medical-reports.edit', $medical_reports->id) }}"><i class="fas fa-notes-medical text-lg mr-2"></i>Update Medical Report</a>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
