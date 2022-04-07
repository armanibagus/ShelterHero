@extends('template')

@section('page-title')
    {{__('Pet Shelters')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pet Shelters</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{Auth::user()->role == 'user' ? url('/user/home') : url('/volunteer/home')}}">Main Menu</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Pet Shelters
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            @foreach($pet_shelters as $shelter)
                <div class="col-lg-3">
                    <a class="btn" style="padding: 0" href="{{route('users.show', $shelter->id)}}">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                            <div style="text-align: center">
                                @if($shelter->photo_title != NULL && $shelter->photo_path != NULL)
                                    @php
                                        $title = trim(str_replace("public/profile-picture/","", $shelter->photo_path));
                                    @endphp
                                    <img class="img-fluid" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="border-radius: 2%; height: 280px; width: 700px; object-fit: cover;">
                                @else
                                    <img class="img-fluid" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture" style="border-radius: 2%; object-fit: cover; height: 280px; width: 700px">
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <strong class="text-lg">{{$shelter->name}}</strong> <i class="fas fa-check-circle text-primary"></i><br>
                                <div class="text-muted text-sm">
                                    {{$shelter->address}}<br>
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
