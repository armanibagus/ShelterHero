@extends('template')

@section('page-title')
    {{__('Pet Medical Report Form')}}
@endsection

@section('content-wrapper')
    @php
        $edit = false;
        $health_check_id = -1;
        if (Request::is('medical-reports/create*')) {
          $health_check_id = $_GET['health_check_id'];
        } else if (Request::is('medical-reports/*/edit')) {
          $health_check_id = $medicalReport->health_check_id;
          $edit = true;
        }
        /*$health_check = DB::table('users')->where('id', $health_check_id)->first();*/
    @endphp
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Pet Medical Report Form')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @if(Auth::user()->role == 'volunteer')
                                <li class="breadcrumb-item"><a href="{{url('/volunteer/home')}}">Main Menu</a></li>
                                <li class="breadcrumb-item"><a href="{{url('/health-checks')}}">Pet Medical Checkup</a></li>
                                <li class="breadcrumb-item"><a href="{{route('health-checks.show', $health_check_id)}}">Request Volunteer Details</a></li>
                                <li class="breadcrumb-item active">{{__('Pet Medical Report Form')}}</li>
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
                                <h2 class="card-title text-bold text-lg text-center" style="float: none">Pet Medical Report Form</h2>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="@if(!$edit){{route('medical-reports.store')}}@else{{route('medical-reports.update', $medicalReport->id)}}@endif">
                                    @csrf
                                    @if($edit)
                                    @method('PUT')
                                    @else
                                    <input id="health-check-id" type="hidden" class="form-control" name="health_check_id" value="{{ Crypt::encrypt($health_check_id) }}" required hidden readonly>
                                    @endif
                                    <div class="form-group">
                                        <label for="allergies-form" class="mb-1">Allergies</label>
                                        <input id="allergies-form" type="text" class="form-control @error('allergies') is-invalid @enderror" name="allergies" placeholder="Enter pet allergies" value="@if(!$edit){{ old('allergies') }}@else{{ $medicalReport->allergies }}@endif" required>
                                        @error('allergies')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="condition-form" class="mb-1">Existing Condition</label>
                                        <input id="condition-form" type="text" class="form-control @error('existing_condition') is-invalid @enderror" name="existing_condition" placeholder="Enter existing condition of pet" value="@if(!$edit){{ old('existing_condition') }}@else{{ $medicalReport->existing_condition }}@endif" required>
                                        @error('existing_condition')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="vaccination-form" class="mb-1">Vaccination</label>
                                        <input id="vaccination-form" type="text" class="form-control @error('vaccination') is-invalid @enderror" name="vaccination" value="@if(!$edit){{ old('vaccination') }}@else{{ $medicalReport->vaccination }}@endif">
                                        <small class="text-muted">If pet doesn't need vaccination, leave it empty.</small>
                                        @error('vaccination')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="diagnosis-form" class="mb-1">Diagnosis</label>
                                        <input id="diagnosis-form" type="text" class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" placeholder="Enter diagnosis of disease" value="@if(!$edit){{ old('diagnosis') }}@else{{ $medicalReport->diagnosis }}@endif" required>
                                        @error('diagnosis')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="test-performed-form" class="mb-1">Test Performed</label>
                                        <input id="test-performed-form" type="text" class="form-control @error('test_performed') is-invalid @enderror" name="test_performed" placeholder="Enter test performed" value="@if(!$edit){{ old('test_performed') }}@else{{ $medicalReport->test_performed }}@endif" required>
                                        @error('test_performed')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="test-result-form" class="mb-1">Test Result</label>
                                        <input id="test-result-form" type="text" class="form-control @error('test_result') is-invalid @enderror" name="test_result" placeholder="Enter test result" value="@if(!$edit){{ old('test_result') }}@else{{ $medicalReport->test_result }}@endif" required>
                                        @error('test_result')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="action-form" class="mb-1">Action</label>
                                        <input id="action-form" type="text" class="form-control @error('action') is-invalid @enderror" name="action" placeholder="Enter action needed" value="@if(!$edit){{ old('action') }}@else{{ $medicalReport->action }}@endif" required>
                                        @error('action')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="medication-form" class="mb-1">Medication</label>
                                        <input id="medication-form" type="text" class="form-control @error('medication') is-invalid @enderror" name="medication" placeholder="Enter medication needed" value="@if(!$edit){{ old('medication') }}@else{{ $medicalReport->medication }}@endif" required>
                                        @error('medication')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="comments" class="mb-1">Comments</label>
                                        <div class="input-group">
                                            <textarea id="comments" type="text" class="form-control @error('comments') is-invalid @enderror" name="comments" placeholder="Type here..." required rows="4">@if(!$edit){{ old('comments') }}@else{{ $medicalReport->comments }}@endif</textarea>
                                            @error('comments')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Submit') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
