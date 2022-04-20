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
            @foreach($health_checks as $checkup)
            <div class="col-lg-3">
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
                            <div class="text-muted text-sm">
                                {{$checkup->address}}<br>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
