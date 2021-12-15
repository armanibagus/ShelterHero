@extends('template')

@section('page-title')
    {{__('View Lost Pet')}}
@endsection

@section('content-wrapper')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lost Pets</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url('/user/home')}}">Main Menu</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Lost Pets
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                @foreach($pets as $pet)
                    @if($pet->status === 'Confirmed')
                    <div class="col-lg-3">
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                            @php
                                $images = DB::table('images')->get();
                                $title = '';
                                foreach ($images as $image)
                                  if($image->pet_id == $pet->id){
                                    $title = trim(str_replace("public/images/","", $image->path));
                                    break;
                                  }

                            @endphp
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div style="text-align: center">
                                <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover">
                            </div>
                            <div class="card-body text-center">
                                <strong class="text-lg">{{$pet->nickname}}</strong>
                                @if($pet->sex === 'Male')
                                    <i class="nav-icon text-blue fas fa-mars"></i>
                                @elseif($pet->sex === 'Female')
                                    <i class="nav-icon text-pink fas fa-venus"></i>
                                @endif
                                <br>
                                {{$pet->petType}}<br>
                                {{$pet->name}}<br>
                                {{$pet->address}}<br>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    @endif
                @endforeach
            </div>
            <!-- /.col -->
        </section>
    </div>

@endsection
