@extends('template')

@section('page-title')
    {{__('Pets')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pets</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            @if(Auth::user()->role == 'user')
                            <a href="{{url('/user/home')}}">Main Menu</a>
                            @elseif(Auth::user()->role == 'volunteer')
                            <a href="{{url('/volunteer/home')}}">Main Menu</a>
                            @elseif(Auth::user()->role == 'pet_shelter')
                            <a href="{{url('/pet-shelter/home')}}">Main Menu</a>
                            @endif
                        </li>
                        @if(Request::is('pets/my-pets'))
                        <li class="breadcrumb-item active">
                            My Pets
                        </li>
                        @else
                        <li class="breadcrumb-item active">
                            Pets
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
            @foreach($allPets as $pet)
                <div class="col-lg-3">
                    <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
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

                                if (Request::is('pets/my-pets')) {
                                    $accepted = '';
                                    $date = new \Carbon\Carbon($pet->pickUpDate);
                                    $expiredate = $date->addDays(7);
                                    if ($pet->status === 'Confirmed' && \Carbon\Carbon::today() < $expiredate) {
                                        foreach ($claimed_pets as $claim) {
                                          if ($pet->id == $claim->id) {
                                            $accepted = 'CLAIMED';
                                          }
                                        }
                                    } else {
                                      foreach ($adopted_pets as $adopt) {
                                          if ($pet->id == $adopt->id) {
                                            $accepted = 'ADOPTED';
                                          }
                                        }
                                    }
                                }
                            @endphp
                            @if(Request::is('pets/my-pets'))
                                @if($accepted == 'ADOPTED' || $accepted == 'CLAIMED')
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon {{$accepted == 'ADOPTED' ? 'bg-primary' : 'bg-success'}} text-lg">
                                            {{__($accepted)}}
                                        </div>
                                    </div>
                                @endif
                            @endif
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
                                    {{$pet->address}}<br>
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
