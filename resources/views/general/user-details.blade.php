@extends('template')

@section('page-title')
    @if((Auth::user()->role == 'user' || Auth::user()->role == 'volunteer') && $user->role == 'pet_shelter')
        {{__('Pet Shelter Details')}}
    @elseif((Auth::user()->role == 'user' || Auth::user()->role == 'pet_shelter') && $user->role == 'volunteer')
        {{__('Volunteer Details')}}
    @endif
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if((Auth::user()->role == 'user' || Auth::user()->role == 'volunteer') && $user->role == 'pet_shelter')
                        <h1>{{__('Pet Shelter Details')}}</h1>
                    @elseif((Auth::user()->role == 'user' || Auth::user()->role == 'pet_shelter') && $user->role == 'volunteer')
                        <h1>{{__('Volunteer Details')}}</h1>
                    @endif
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
                        @if((Auth::user()->role == 'user' || Auth::user()->role == 'volunteer') && $user->role == 'pet_shelter')
                            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Pet Shelters</a></li>
                            <li class="breadcrumb-item active">{{__('Pet Shelter Details')}}</li>
                        @elseif((Auth::user()->role == 'user' || Auth::user()->role == 'pet_shelter') && $user->role == 'volunteer')
                            @if(Auth::user()->role == 'pet_shelter')
                            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Request Volunteer</a></li>
                            @endif
                            <li class="breadcrumb-item active">{{__('Volunteer Details')}}</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if($user->photo_title != NULL && $user->photo_path != NULL)
                                    @php
                                        $title = trim(str_replace("public/profile-picture/","", $user->photo_path));
                                    @endphp
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 100px; width: 100px; object-fit: cover;">
                                @else
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                @endif
                            </div>
                            <div class="profile-username text-center"><strong>{{__($user->name)}}</strong> <i class="fas fa-check-circle text-primary text-sm "></i></div>
                            <p class="text-muted text-center">
                                @if($user->role == 'pet_shelter')
                                    {{__('Pet Shelter')}}
                                @elseif($user->role == 'volunteer')
                                    {{__('Volunteer')}}
                                @endif
                            </p>
                            <ul class="list-group list-group-unbordered mb-3">
                                @if($user->role == 'pet_shelter' || $user->role == 'volunteer')
                                <li class="list-group-item">
                                    <strong>Licenses</strong> <span class="text-muted float-right">{{__($user->identityNumber)}}</span>
                                </li>
                                @endif
                            </ul>
                            @if(Auth::user()->role == 'pet_shelter')
                                <form method="GET" action="{{ route('health-checks.create') }}">
                                    <input id="user_id" type="number" name="user_id" value="{{$user->id}}" hidden readonly>
                                    <button type="submit" class="btn btn-success btn-block text-bold" >
                                        {{ __('Send Request') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Contact</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-phone-square-alt mr-1"></i> Phone Number</strong>
                            <p class="text-muted">{{__($user->phoneNumber)}}</p>
                            <hr>
                            <strong><i class="fas fa-envelope mr-1"></i> Email Address</strong>
                            <p class="text-muted">{{__($user->email)}}</p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                            <p class="text-muted">{{__($user->address)}} </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-9">
                    @if((Auth::user()->role == 'user' || Auth::user()->role == 'volunteer') && $user->role == 'pet_shelter')
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="small-box bg-white shadow" style="background-color: #eadece!important;">
                                <div class="inner">
                                    <h3>{{ __(count($pets)) }}</h3>
                                    <p>Pets</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-paw"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-6">
                            <div class="small-box bg-primary shadow">
                                <div class="inner">
                                    <h3>{{ __(count($acc_adopt_pets)) }}</h3>
                                    <p>Adopted</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-6">
                            <div class="small-box bg-success shadow">
                                <div class="inner">
                                    <h3>{{ __(count($acc_claim_pets)) }}</h3>
                                    <p>Claimed</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="mt-3"><strong>Pets from {{__($user->name)}}</strong></h3>
                    @elseif((Auth::user()->role == 'pet_shelter' || Auth::user()->role == 'user') && $user->role == 'volunteer')
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            <div class="small-box bg-white shadow" style="background-color: #eadece!important;">
                                <div class="inner">
                                    <h3>{{ __($pets->count()) }}</h3>
                                    <p>Pet Medical Checkup</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-heartbeat text-danger"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <div class="small-box bg-success shadow">
                                <div class="inner">
                                    <h3>{{ __($accepted_request) }}</h3>
                                    <p>Accepted Request</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                        @if(Auth::user()->role == 'user')
                            <h3 class="mt-3"><strong>Pets Examined by {{__($user->name)}}</strong></h3>
                        @endif
                        @if(Auth::user()->role == 'pet_shelter')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-white">
                                    <div class="card-header" style="background-color: #eadece!important;">
                                        <h3 class="card-title"><strong>Pets Examined by {{__($user->name)}}</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body table-responsive p-0">
                                            <table id="dataTable1" class="table table-head-fixed text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Nickname</th>
                                                    <th>Date</th>
                                                    <th> </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pets as $pet)
                                                    <tr>
                                                        <td class="text-center">{{ $pet->id }}</td>
                                                        <td>{{ $pet->nickname }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($pet->checkup_date)->isoFormat('DD MMMM YYYY') }}</td>
                                                        <td><a class="btn btn-default" href="{{ route('pets.show', $pet->id) }}">View <i class="fas fa-eye"></i></a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><strong>Your Request</strong></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body table-responsive p-0">
                                            <table id="dataTable5" class="table table-head-fixed text-nowrap">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th> </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($health_check as $my_request)
                                                    <tr>
                                                        <td class="text-center">{{$my_request->id}}</td>
                                                        <td>{{date('d M Y', strtotime($my_request->checkup_date))}}</td>
                                                        <td>
                                                        @if($my_request->status == 'Accepted')
                                                            <strong><i class="fas fa-check-circle fa-lg text-success"></i></strong>
                                                        @elseif($my_request->status == 'Pending')
                                                            <strong> <i class="fas fa-spinner fa-lg text-gray"></i></strong>
                                                        @elseif($my_request->status == 'Rejected')
                                                            <strong><i class="fas fa-times fa-lg text-danger"></i></strong>
                                                        @endif
                                                        </td>
                                                        <td><a href="{{ route('health-checks.show', $my_request->id) }}" class="btn btn-default">View <i class="fas fa-eye"></i></a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="row">
                                @foreach($pets as $pet)
                                    <div class="col-lg-4">
                                        <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                                            <!-- Widget: user widget style 1 -->
                                            <div class="card card-widget widget-user">
                                                @php
                                                    $images = DB::table('images')->get();
                                                    $title = ''; $accepted = '';
                                                    foreach ($images as $image)
                                                      if($image->pet_id == $pet->id){
                                                        $title = trim(str_replace("public/images/","", $image->path));
                                                        break;
                                                      }
                                                @endphp
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
                                                    {{ __($pet->size) }} • {{ __($pet->petType) }}
                                                </div>
                                                <div class="card-footer text-sm text-right" style="padding-top: 15px">
                                                    {{ \Carbon\Carbon::parse($pet->checkup_date)->isoFormat('DD MMMM YYYY') }}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    @if($user->role == 'pet_shelter')
                    <div class="row">
                        @foreach($pets as $pet)
                        <div class="col-lg-4">
                            <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                                <!-- Widget: user widget style 1 -->
                                <div class="card card-widget widget-user">
                                    @php
                                      $images = DB::table('images')->get();
                                      $title = ''; $accepted = '';
                                      foreach ($images as $image)
                                        if($image->pet_id == $pet->id){
                                          $title = trim(str_replace("public/images/","", $image->path));
                                          break;
                                        }
                                      $date = new \Carbon\Carbon($pet->pickUpDate);
                                      $expiredate = $date->addDays(7);
                                      /*if ($pet->status === 'Confirmed' && \Carbon\Carbon::today() < $expiredate) {*/
                                          foreach ($acc_claim_pets as $claim) {
                                            if ($pet->id == $claim->id) {
                                              $accepted = 'CLAIMED';
                                            }
                                         }
                                      /*} else {*/
                                      foreach ($acc_adopt_pets as $adopt) {
                                        if ($pet->id == $adopt->id) {
                                          $accepted = 'ADOPTED';
                                        }
                                      }
                                      /*}*/
                                    @endphp
                                    @if($accepted == 'ADOPTED' || $accepted == 'CLAIMED')
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon {{$accepted == 'ADOPTED' ? 'bg-primary' : 'bg-success'}} text-lg">
                                            {{__($accepted)}}
                                        </div>
                                    </div>
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
                                        {{ __($pet->size) }} • {{ __($pet->petType) }}
                                    </div>
                                    <div class="card-footer text-sm text-right" style="padding-top: 15px">
                                        {{ __(\Carbon\Carbon::createFromDate($pet->created_at)->diffForHumans()) }}
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
