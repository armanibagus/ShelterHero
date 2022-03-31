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
                                <img src="{{asset('artefact/dist/img/unknown.png')}}" alt="User profile image" class="img-fluid" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
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
