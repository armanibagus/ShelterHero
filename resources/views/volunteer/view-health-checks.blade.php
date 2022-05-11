@extends('template')

@section('page-title')
    {{__('Pet Medical Checkup')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Pet Medical Checkup')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/volunteer/home')}}">Main Menu</a></li>
                        <li class="breadcrumb-item active">{{__('Pet Medical Checkup')}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist" >
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#pending-tab" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="true">Pending Request</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#ready-to-examined-tab" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Ready to Examined</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#completed-tab" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Completed</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-five-tabContent">
                            <div class="tab-pane fade show active" id="pending-tab" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                <div class="card-body p-1 row @if($health_checks_pending->count() < 1) justify-content-center @endif">
                                    @if($health_checks_pending->count() > 0)
                                    @foreach($health_checks_pending as $checkup)
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
                                    @endforeach
                                    @else
                                        <p>No data available</p>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ready-to-examined-tab" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                <div class="card-body p-1 row @if(count($health_checks_examined) < 1) justify-content-center @endif">
                                    @if(count($health_checks_examined) > 0)
                                        @foreach($health_checks_examined as $checkup)
                                        <div class="col-md-3">
                                            <a class="btn" style="padding: 0" href="{{route('health-checks.show', $checkup->id)}}">
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
                                    @endforeach
                                    @else
                                        <p>No data available</p>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="completed-tab" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                <div class="card-body p-1 row @if(count($health_checks_completed) < 1) justify-content-center @endif">
                                    @if(count($health_checks_completed) > 0)
                                        @foreach($health_checks_completed as $checkup)
                                        <div class="col-md-3">
                                            <a class="btn" style="padding: 0" href="{{route('health-checks.show', $checkup->id)}}">
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
                                    @endforeach
                                    @else
                                        <p>No data available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</div>
@endsection
