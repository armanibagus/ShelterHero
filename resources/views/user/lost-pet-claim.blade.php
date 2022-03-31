@extends('template')

@section('page-title')
    {{__('Lost Pet Claim')}}
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lost Pet Claim</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url('/user/home')}}">Main Menu</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Lost Pet Claim
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                @foreach($listOfPets as $pet)
                    <div class="col-lg-3">
                        <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                            <div class="card card-widget widget-user">
                            @php
                                $images = DB::table('images')->get();
                                $title = '';
                                foreach ($images as $image) {
                                  if($image->pet_id == $pet->id){
                                    $title = trim(str_replace("public/images/","", $image->path));
                                    break;
                                  }
                                }
                                $pet_shelter = DB::table('users')->where('id', $pet->shelter_id)->first();
                            @endphp
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div style="text-align: center">
                                    <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                </div>
                                <div class="card-body text-center">
                                    <strong class="text-lg">{{$pet->nickname}}</strong>
                                    @if($pet->sex === 'Male')
                                        <i class="nav-icon text-blue fas fa-mars"></i>
                                    @elseif($pet->sex === 'Female')
                                        <i class="nav-icon text-pink fas fa-venus"></i>
                                    @endif
                                    <br>
                                    {{ __($pet->size) }} • {{ __($pet->petType) }}<br>
                                    <div class="text-muted text-sm">
                                        {{$pet_shelter->address}}<br>
                                    </div>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- /.col -->
        </section>
    </div>
@endsection
