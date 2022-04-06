@extends('template')

@section('page-title')
    {{__('Pet Details')}}
@endsection

@section('content-wrapper')
    @php
        $i = $a = 0; $p = 0; $totalAdopt = 0; $totalClaim = 0;
        $adp = 0; $clm = 0; $accepted = false; $tab_name = '';
        $allData = array();
        $routeType = '';
        $btnName = '';
        $route_data = '';
        $id_tab = '';

        $date = new \Carbon\Carbon($pet->pickUpDate);
        $expiredate = $date->addDays(7);
    @endphp
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pet Details</h1>
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
                            @if(Auth::user()->role == 'user' || Auth::user()->role == 'pet_shelter')
                            @if(\Carbon\Carbon::today() > $expiredate)
                                @if(Auth::user()->role == 'user')
                                    <li class="breadcrumb-item"><a href="{{route('adoptions.index')}}">Pet Adoption</a></li>
                                @elseif(Auth::user()->role == 'pet_shelter')
                                    <li class="breadcrumb-item"><a href="{{route('adoptions.index')}}">Adoption Request</a></li>
                                @endif
                            @elseif(\Carbon\Carbon::today() < $expiredate)
                                <li class="breadcrumb-item"><a href="{{route('lost-pet-claims.index')}}">Lost Pet Claim</a></li>
                            @endif
                            @elseif(Auth::user()->role == 'volunteer')
                                <li class="breadcrumb-item"><a href="{{route('pets.index')}}">Pets</a></li>
                            @endif
                            <li class="breadcrumb-item active">Pet Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6" style="margin-top: 1.25rem">
                            <div class="col-6" style="margin: auto !important;">
                            @php
                                $images = DB::table('images')->get();
                                $title = '';
                                foreach ($images as $image)
                                  if($image->pet_id == $pet->id){
                                    $title = trim(str_replace("public/images/","", $image->path));
                                  }
                            @endphp
                                <img src="{{ asset('storage/images/'.$title) }}" class="product-image" alt="Pet Image" style="object-fit: cover;">
                            </div>
                            <div class="col-6 product-image-thumbs">
                                @php
                                    $images = DB::table('images')->get();
                                    $title = '';
                                    foreach ($images as $image)
                                      if($image->pet_id == $pet->id){
                                        $title = trim(str_replace("public/images/","", $image->path));
                                @endphp
                                <div class="product-image-thumb active"><img src="{{ asset('storage/images/'.$title) }}" alt="Pet Image"></div>
                                @php
                                  }
                                @endphp
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h1 class="my-4">
                            <strong>{{ $pet->nickname }}</strong>
                            @if($pet->sex === 'Male')
                                <i class="nav-icon text-blue fas fa-mars"></i>
                            @elseif($pet->sex === 'Female')
                                <i class="nav-icon text-pink fas fa-venus"></i>
                            @endif
                            </h1>
                            <h3 class="my-3">{{ $pet->petType }} </h3>

                            @php
                                $pet_shelter = DB::table('users')->where('id', $pet->shelter_id)->first();
                            @endphp
                            <div class="card-body table-responsive p-0">
                                <table class="table">
                                    <tr>
                                        <th>Shelter Address</th>
                                        <td>{{ $pet_shelter->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shelter Name</th>
                                        <td>{{ $pet_shelter->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shelter ID</th>
                                        <td>{{ $pet_shelter->identityNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pet ID</th>
                                        <td>{{ $pet->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Age</th>
                                        <td>{{ $pet->age }} Years</td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <td>{{ $pet->size }}</td>
                                    </tr>
                                    <tr>
                                        <th>Weight</th>
                                        <td>{{ $pet->weight }} Kg</td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>

                            @php
                              $allAdoptions = DB::table('adoptions')->get();
                              $allClaims = DB::table('lost_pet_claims')->get();
                              $isAdopted = \App\Http\Controllers\PetController::petIsAccepted($pet, $allAdoptions);
                              $isClaimed = \App\Http\Controllers\PetController::petIsAccepted($pet, $allClaims);
                              if ($isAdopted || $isClaimed) {
                                $i = 1; $p = -1; $id_tab = 'accepted-tab';
                                if ($isAdopted) {
                                  foreach ($allAdoptions as $data) {
                                    if ($data->pet_id == $pet->id) {
                                      if ($data->status == 'Accepted') {
                                        if (Auth::user()->role == 'user') {
                                          $data->user_id == Auth::user()->id ? $a = 1 : $a = -1;
                                        } else if (Auth::user()->role == 'pet_shelter') {
                                          $accepted = true;
                                          $tab_name = 'Adopted';
                                          $allData[] = $data;
                                          $route_data = 'adoptions.edit';
                                        } break;
                                      }
                                    }
                                  }
                                } else {
                                  foreach ($allClaims as $data) {
                                    if ($data->pet_id == $pet->id) {
                                      if ($data->status == 'Accepted') {
                                        if (Auth::user()->role == 'user') {
                                          $data->user_id == Auth::user()->id ? $a = 1 : $a = -1;
                                        } else if (Auth::user()->role == 'pet_shelter') {
                                          $accepted = true;
                                          $tab_name = 'Claimed';
                                          $allData[] = $data;
                                          $route_data = 'lost-pet-claims.edit';
                                        } break;
                                      }
                                    }
                                  }
                                }
                              }
                              if (Auth::user()->role == 'user') {
                                if (!$isAdopted && !$isClaimed) {
                                  if (\Carbon\Carbon::today() > $expiredate) {
                                    $allData = DB::table('adoptions')->get();
                                    $routeType = route('adoptions.create');
                                    $btnName = 'Request for Adoption';
                                  } else {
                                    $allData = DB::table('lost_pet_claims')->get();
                                    $routeType = route('lost-pet-claims.create');
                                    $btnName = 'Make a Claim';
                                  }
                                  foreach ($allData as $data) {
                                    if ($data->pet_id == $pet->id) {
                                      if ($data->user_id == Auth::user()->id && $data->status == 'Pending') {
                                        $i = 1; $p = 1;
                                      }
                                      else if ($data->status == 'Accepted') {
                                        $i = 1; $p = -1;
                                        $data->user_id == Auth::user()->id ? $a = 1 : $a = -1;
                                        break;
                                      }
                                    }
                                  }
                                }
                              } else if (Auth::user()->role == 'pet_shelter' && Auth::user()->id == $pet->shelter_id) {
                                $i = 1; $p = -1; $a = -1;
                                if (!$isAdopted && !$isClaimed) {
                                    if (\Carbon\Carbon::today() > $expiredate) {
                                      $adp = 1;
                                      $id_tab = 'adoptions-requests';
                                      $route_data = 'adoptions.edit';
                                      $allAdoptions = DB::table('adoptions')->get();
                                      foreach ($allAdoptions as $adopt) {
                                        if ($adopt->pet_id == $pet->id && $adopt->shelter_id == Auth::user()->id &&
                                          $adopt->status == 'Pending') {
                                          $totalAdopt++;
                                          $allData[] = $adopt;
                                        }
                                      }
                                    } else {
                                      $clm = 1;
                                      $id_tab = 'lost-pet-claims';
                                      $route_data = 'lost-pet-claims.edit';
                                      $allClaims = DB::table('lost_pet_claims')->get();
                                      foreach ($allClaims as $claim) {
                                        if ($claim->pet_id == $pet->id && $claim->shelter_id == Auth::user()->id &&
                                          $claim->status == 'Pending') {
                                          $totalClaim++;
                                          $allData[] = $claim;
                                        }
                                      }
                                    }
                                }
                              }
                              $arrLength = count($allData);
                            @endphp
                            @if(Auth::user()->role == 'user')
                                @if($i < 1)
                                <form method="GET" action="{{$routeType}}">
                                    <input id="pet_id" type="number" name="pet_id" value="{{$pet->id}}" hidden>
                                    <button type="submit" class="btn btn-success btn-block btn-lg mt-3" >
                                        @if($btnName == 'Request for Adoption')
                                            <i class="fas fa-hand-holding-heart fa-lg mr-2"></i>
                                        @else
                                            <i class="fas fas fa-check-circle fa-lg mr-2"></i>
                                        @endif
                                        {{ __($btnName) }}
                                    </button>
                                </form>
                                @endif
                                @if($p > 0)
                                <div class="btn btn-secondary btn-block btn-lg mt-3 disabled">
                                    <i class="fas fa-spinner fa-lg mr-2"></i>
                                    Pending
                                </div>
                                @endif
                                @if($a > 0)
                                    <div class="btn btn-success btn-block btn-lg mt-3 disabled">
                                        <i class="fas fa-check-circle fa-lg mr-2"></i>
                                        Accepted
                                    </div>
                                @endif
                            @endif
                        </div>
                </div>
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="pet-tab" role="tablist">
                            <a class="nav-item nav-link active" id="pet-condition-tab" data-toggle="tab" href="#pet-condition" role="tab" aria-controls="pet-condition" aria-selected="true">
                                Condition
                            </a>
                            @if($adp > 0)
                            <a class="nav-item nav-link" id="adoptions-requests-tab" data-toggle="tab" href="#adoptions-requests" role="tab" aria-controls="adoptions-requests" aria-selected="false">
                                Adoption Request ({{$totalAdopt}})
                            </a>
                            @elseif($clm > 0)
                            <a class="nav-item nav-link" id="lost-pet-claims-tab" data-toggle="tab" href="#lost-pet-claims" role="tab" aria-controls="lost-pet-claims" aria-selected="false">
                                Lost Pet Claim ({{$totalClaim}})
                            </a>
                            @elseif($accepted)
                                <a class="nav-item nav-link" id="lost-pet-claims-tab" data-toggle="tab" href="#accepted-tab" role="tab" aria-controls="lost-pet-claims" aria-selected="false">
                                    {{ $tab_name }} by
                                </a>
                            @endif
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="pet-condition" role="tabpanel" aria-labelledby="pet-condition-tab">
                            {{ __($pet->condition) }}
                        </div>
                        @if($adp > 0 || $clm > 0 || $accepted)
                        <div class="tab-pane fade" id="{{($id_tab)}}" role="tabpanel" aria-labelledby="adoptions-requests-tab">
                            <div class="row">
                                @foreach($allData as $data)
                                <div class="{{ $arrLength == 1 ? 'col-lg-5' : 'col-lg-3' }}">
                                    <a class="btn" style="padding: 0" href="{{route($route_data, $data->id)}}">
                                        <div class="card card-widget widget-user">
                                            <div style="text-align: center">
                                                <img src="{{asset('artefact/dist/img/unknown.png')}}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 700px">
                                            </div>
                                            <div class="card-body text-center">
                                                <strong class="text-lg">{{$data->name}}</strong><br>
                                                {{$data->state}}, {{$data->country}}<br>
                                                {{$data->phone}}<br>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
