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
                        @elseif(Request::is('health-checks/*/edit') && Auth::user()->role == 'volunteer')
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
                                <h6><strong>Shelter Name</strong></h6>
                                <p>
                                    {{ __($pet_shelter->name) }}
                                </p>
                                <hr>
                                <h6><strong>Proposed Checkup Date</strong></h6>
                                <p>
                                    {{date('d M Y', strtotime($healthCheck->checkup_date))}}
                                </p>
                                <hr>
                                <h6><strong>Description</strong></h6>
                                <p>
                                    {{ __($healthCheck->description) }}
                                </p>
                                <hr>
                                @if(Request::is('health-checks/*/edit') && Auth::user()->role == 'volunteer')
                                    <form method="POST" action="{{ route('health-checks.update', $healthCheck->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label class="mt-3">Status</label>
                                            <select id="status" type="text" name="status" class="form-control @error('status') is-invalid @enderror" required>
                                                <option selected disabled value="" >---[Select one]---</option>
                                                <option value="Rejected">Rejected</option>
                                                <option value="Accepted">Accepted</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label id="feedbackLabel" class="mb-1">Feedback</label>
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
