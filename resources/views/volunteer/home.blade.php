@extends('template')

@section('content-wrapper')
<div class="content-wrapper">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @php
        $medical_reports = \App\Models\HealthCheck::join('medical_reports', 'medical_reports.health_check_id', '=', 'health_checks.id')
                                            ->join('pets', 'pets.id', '=', 'health_checks.pet_id')
                                            ->join('users', 'users.id', '=', 'pets.shelter_id')
                                            ->select(['medical_reports.*', 'pets.id', 'users.name'])->latest()->first();
        $pet_img = '';
        if($medical_reports != NULL) {
          $img = \App\Models\Image::where('pet_id', '=', $medical_reports->id)->first();
          if ($img != NULL)
            $pet_img = trim(str_replace("public/images/","", $img->path));
        }

        $health_checks = \App\Models\HealthCheck::join('users', 'users.id', '=', 'health_checks.shelter_id')
                            ->select(['health_checks.*', 'users.name', 'users.address', 'users.photo_path', 'users.photo_title'])
                            ->where([['status', '=', 'Pending'],
                                     ['volunteer_id', '=', Auth::user()->id]])
                            ->orderBy('health_checks.checkup_date', 'DESC')
                            ->latest()->get();
    @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Main Menu</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card bg-transparent">
            <h2 class="card-title text-bold text-lg text-center ml-auto mr-auto pr-3 pl-3" style="margin-top: -12px; background-color: #f4f6f9">{{ __('Your Request') }}</h2>
            <div class="card-body row pb-0">
                @if(count($health_checks) > 0)
                    @php
                        $checks = 0;
                        foreach($health_checks as $checkup) {
                          if ($checks < 4)
                            $checks++;
                          else
                            break;
                    @endphp
                    <div class="col-md-3">
                        <a class="btn" style="padding: 0" href="{{route('health-checks.edit', $checkup->id)}}">
                            <div class="card card-widget widget-user">
                                <div style="text-align: center">
                                    @if($checkup->photo_title != NULL && $checkup->photo_path != NULL)
                                        @php
                                            $title = trim(str_replace("public/profile-picture/","", $checkup->photo_path));
                                        @endphp
                                        <img class="img-fluid" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="border-radius: 2%; height: 280px; width: 700px; object-fit: cover;">
                                    @else
                                        <img class="img-fluid" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture" style="border-radius: 2%; object-fit: cover; height: 280px; width: 700px">
                                    @endif
                                </div>
                                <div class="card-body text-center">
                                    <strong class="text-lg">{{$checkup->name}}</strong> <i class="fas fa-check-circle text-primary"></i><br>
                                    <div class="text-sm">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <strong>{{ \Carbon\Carbon::parse($checkup->checkup_date)->isoFormat('DD MMMM YYYY') }}</strong><br>
                                    </div>
                                    <div class="text-muted text-sm">
                                        {{$checkup->address}}<br>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @php } @endphp
                @else
                    <p class="text-center m-0 p-3">{{ __('No data available') }}</p>
                @endif
            </div>
            <div class="p-0 text-center rounded">
                <a class="btn btn-block" href="{{route('health-checks.index')}}">
                    <strong class="text-secondary">View More<i class="fas fa-arrow-right ml-2"></i></strong>
                </a>
            </div>
        </div>
        <div class="card">
            @if($medical_reports != NULL)
                <div class="card-body row ml-3 mr-3 mb-3 ">
                    <div class="col-md-6 align-self-center order-2 order-md-1">
                        <h2 class="card-title text-bold text-lg text-center float-none mt-2 mb-4">{{ __('Medical Report') }}</h2>
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
                        <div class="text-center">
                            <a class="btn btn-success" href="{{ route('health-checks.show', $medical_reports->health_check_id) }}">{{ __('Find out more') }}</a>
                        </div>
                    </div>
                    <div class="col-md-6 order-1 order-md-2">
                        <img class="img-fluid mt-4" src="{{ asset('storage/images/'.$pet_img) }}" alt="Pet picture" style="border-radius: 2%; height: 400px; width: 100%; object-fit: cover;">
                    </div>
                </div>
            @else
                <p class="text-center m-0 p-3">{{ __('No data available') }}</p>
            @endif
        </div>
        <!-- /.card -->
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
