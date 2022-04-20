@extends('template')

@section('page-title')
    @if(Auth::user()->role == 'user' || Auth::user()->role == 'volunteer')
    {{__('Pet Shelters')}}
    @elseif(Auth::user()->role == 'pet_shelter')
    {{__('Request Volunteer')}}
    @endif
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if(Auth::user()->role == 'user' || Auth::user()->role == 'volunteer')
                        <h1>{{__('Pet Shelters')}}</h1>
                    @elseif(Auth::user()->role == 'pet_shelter')
                        <h1>{{__('Request Volunteer')}}</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'user' || Auth::user()->role == 'volunteer')
                        <li class="breadcrumb-item">
                            <a href="{{Auth::user()->role == 'user' ? url('/user/home') : url('/volunteer/home')}}">Main Menu</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{__('Pet Shelters')}}
                        </li>
                        @elseif(Auth::user()->role == 'pet_shelter')
                            <li class="breadcrumb-item">
                                <a href="{{url('/pet-shelter/home')}}">Main Menu</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{__('Request Volunteer')}}
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            @foreach($users as $user)
                <div class="col-lg-3">
                    <a class="btn" style="padding: 0" href="{{route('users.show', $user->id)}}">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                            <div style="text-align: center">
                                @if($user->photo_title != NULL && $user->photo_path != NULL)
                                    @php
                                        $title = trim(str_replace("public/profile-picture/","", $user->photo_path));
                                    @endphp
                                    <img class="img-fluid" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="border-radius: 2%; height: 280px; width: 700px; object-fit: cover;">
                                @else
                                    <img class="img-fluid" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture" style="border-radius: 2%; object-fit: cover; height: 280px; width: 700px">
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <strong class="text-lg">{{$user->name}}</strong> <i class="fas fa-check-circle text-primary"></i><br>
                                <div class="text-muted text-sm">
                                    {{$user->address}}<br>
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
