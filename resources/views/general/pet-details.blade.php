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
        $allAdoptions = DB::table('adoptions')->get();
        $allClaims = DB::table('lost_pet_claims')->get();
        $isAdopted = \App\Http\Controllers\PetController::petIsAccepted($pet, $allAdoptions);
        $isClaimed = \App\Http\Controllers\PetController::petIsAccepted($pet, $allClaims);

        $medical_reports = \App\Models\HealthCheck::join('medical_reports', 'medical_reports.health_check_id', '=', 'health_checks.id')
                                                      ->join('users', 'users.id', '=', 'health_checks.volunteer_id')
                                                      ->where('health_checks.pet_id', '=', $pet->id)
                                                      ->select(['medical_reports.*', 'health_checks.checkup_date', 'health_checks.volunteer_id', 'users.name', 'users.photo_title', 'users.photo_path', 'users.identityNumber'])
                                                      ->orderBy('health_checks.checkup_date', 'DESC')->latest()->get();
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
                                @if($isAdopted || $isClaimed)
                                    @if(Auth::user()->role == 'pet_shelter')
                                        <li class="breadcrumb-item"><a href="{{route('pets.myPets')}}">My Pets</a></li>
                                    @endif
                                @else
                                    @if(\Carbon\Carbon::today() > $expiredate)
                                        @if(Auth::user()->role == 'user')
                                            <li class="breadcrumb-item"><a href="{{route('adoptions.index')}}">Pet Adoption</a></li>
                                        @elseif(Auth::user()->role == 'pet_shelter')
                                            <li class="breadcrumb-item"><a href="{{route('adoptions.index')}}">Adoption Request</a></li>
                                        @endif
                                    @elseif(\Carbon\Carbon::today() < $expiredate)
                                        <li class="breadcrumb-item"><a href="{{route('lost-pet-claims.index')}}">Lost Pet Claim</a></li>
                                    @endif
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
                                    break;
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
                            @if(Auth::user()->role == 'pet_shelter' && $pet->shelter_id == Auth::user()->id)
                            <a class="btn btn-default float-right" href="{{ route('pets.edit', $pet->id) }}"><h3 class="card-title"><i class="fas fa-edit"></i> Edit Pet</h3><a/>
                            @endif
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
                                        <th>Shelter License</th>
                                        <td>{{ $pet_shelter->identityNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shelter Name</th>
                                        <td>{{ $pet_shelter->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shelter Address</th>
                                        <td>{{ $pet_shelter->address }}</td>
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
                                            <i class="fas fa-check-circle fa-lg mr-2"></i>
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
                            <a class="nav-item nav-link" id="medical-report-tab" data-toggle="tab" href="#medical-report" role="tab" aria-controls="medical-report" aria-selected="true">
                                Medical Report
                            </a>
                            @if(Auth::user()->role == 'user')
                                @php
                                  $user_request_adoptions = \App\Models\Adoption::where([['user_id', '=', Auth::user()->id],
                                                                                          ['pet_id', '=', $pet->id]])->orderBy('created_at', 'DESC')->latest()->get();
                                  $user_request_claims = \App\Models\LostPetClaim::where([['user_id', '=', Auth::user()->id],
                                                                                          ['pet_id', '=', $pet->id]])->orderBy('created_at', 'DESC')->latest()->get();
                                @endphp
                                @if($user_request_claims->count() > 0)
                                    <a class="nav-item nav-link" id="claim-tab" data-toggle="tab" href="#lost-pet-claims" role="tab" aria-controls="claim-request" aria-selected="true">
                                        Lost Pet Claims
                                    </a>
                                @endif
                                @if($user_request_adoptions->count() > 0)
                                    <a class="nav-item nav-link" id="adoption-tab" data-toggle="tab" href="#adoption" role="tab" aria-controls="adoption-request" aria-selected="true">
                                        Adoption Requests
                                    </a>
                                @endif
                            @elseif(Auth::user()->role == 'pet_shelter')
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
                            @endif
                        </div>
                    </nav>
                    <div class="tab-content p-3  w-100 " id="nav-tabContent">
                        <div class="tab-pane fade show active" id="pet-condition" role="tabpanel" aria-labelledby="pet-condition-tab">
                            {{ __($pet->condition) }}
                        </div>
                        <div class="tab-pane fade" id="medical-report" role="tabpanel" aria-labelledby="medical-report-tab">
                            <div id="accordion">
                            @if($medical_reports->count() > 0)
                                @foreach($medical_reports as $report)
                                    @php
                                        $link = Crypt::encrypt($report->id);
                                        $recent_report = $medical_reports->first();
                                    @endphp
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#{{ __($link) }}">
                                                    by {{ __($report->name) }}, {{ \Carbon\Carbon::parse($report->checkup_date)->isoFormat('DD MMMM YYYY') }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="{{ __($link) }}" class="collapse @if($report->id == $recent_report->id)show @endif" data-parent="#accordion">
                                            <div class="card-body pr-5 pl-5">
                                                    <div class="text-center">
                                                        <h5><strong>Volunteer</strong></h5><br>
                                                        <a @if(Auth::user()->role == 'pet_shelter' || Auth::user()->role == 'user')href="{{ route('users.show', $report->volunteer_id) }}"@endif style="color: #000">
                                                            @if($report->photo_title != NULL && $report->photo_path != NULL)
                                                                @php
                                                                    $title = trim(str_replace("public/profile-picture/","", $report->photo_path));
                                                                @endphp
                                                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 100px; width: 100px; object-fit: cover;">
                                                            @else
                                                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                                            @endif
                                                            <p>
                                                                <strong>{{ __($report->name) }}</strong>
                                                            </p>
                                                        </a>
                                                        <p>
                                                            Medical License {{ __($report->identityNumber) }}
                                                        </p>
                                                    </div>
                                                    <hr>
                                                <h4 class="text-center"><strong>Medical Report</strong></h4><br>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-6" style="border-left: 0.25rem solid #000">
                                                        <h6><strong>Allergies</strong></h6>
                                                        <p>
                                                            {{ ($report->allergies) }}
                                                        </p>
                                                        <hr>
                                                        <h6><strong>Existing Condition</strong></h6>
                                                        <p>
                                                            {{ ($report->existing_condition) }}
                                                        </p>
                                                        <hr>
                                                        <h6><strong>Vaccination</strong></h6>
                                                        <p>
                                                            @if($report->vaccination != NULL)
                                                                {{ ($report->vaccination) }}
                                                            @else
                                                                {{ __('-') }}
                                                            @endif
                                                        </p>
                                                        <hr>
                                                        <h6><strong>Diagnosis</strong></h6>
                                                        <p>
                                                            {{ ($report->diagnosis) }}
                                                        </p>
                                                        <hr style="margin-bottom: 0!important;">
                                                    </div>
                                                    <div class="col-md-6" style="border-left: 0.25rem solid #000">
                                                        <h6><strong>Test Performed</strong></h6>
                                                        <p>
                                                            {{ ($report->test_performed) }}
                                                        </p>
                                                        <hr>
                                                        <h6><strong>Test Result</strong></h6>
                                                        <p>
                                                            {{ ($report->test_result) }}
                                                        </p>
                                                        <hr>
                                                        <h6><strong>Action</strong></h6>
                                                        <p>
                                                            {{ ($report->action) }}
                                                        </p>
                                                        <hr>
                                                        <h6><strong>Medication</strong></h6>
                                                        <p>
                                                            {{ ($report->medication) }}
                                                        </p>
                                                        <hr style="margin-bottom: 0!important;">
                                                    </div>
                                                    <div class="col-md-12 mb-3 pt-3" style="border-left: 0.25rem solid #000">
                                                        <h6><strong>Comments</strong></h6>
                                                        <p>
                                                            {{ ($report->comments) }}
                                                        </p>
                                                        <hr style="margin-bottom: 0!important;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{ __('No data available') }}
                            @endif
                            </div>
                        </div>
                        @if(Auth::user()->role == 'user')
                            @if($user_request_claims->count() > 0)
                            <div class="tab-pane fade" id="lost-pet-claims" role="tabpanel" aria-labelledby="claims-tab">
                                <div class="timeline timeline-inverse">
                                    @php
                                        $new_date = $user_request_claims->first()->created_at;
                                    @endphp
                                    @foreach($user_request_claims as $claim)
                                        @if($new_date > \Carbon\Carbon::createFromDate($claim->created_at)->addDay())
                                            @php $new_date = $claim->created_at; @endphp
                                        @endif
                                        @if($new_date == $claim->created_at)
                                            <div class="time-label">
                                                <span class="bg-primary">
                                                  {{date('d M Y', strtotime($new_date))}}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            @if($claim->status == 'Accepted')
                                                <i class="fas fa-check-circle bg-success"></i>
                                            @elseif($claim->status == 'Pending')
                                                <i class="fas fa-spinner bg-gray"></i>
                                            @elseif($claim->status == 'Rejected')
                                                <i class="fas fa-times bg-danger"></i>
                                            @endif
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{ __(\Carbon\Carbon::createFromDate($claim->created_at)->diffForHumans()) }}</span>
                                                <h3 class="timeline-header @if($claim->status == 'Accepted') text-success @elseif($claim->status == 'Pending') text-muted @elseif($claim->status == 'Rejected') text-danger @endif">
                                                    <strong>Claim {{ __($claim->status) }}</strong>
                                                </h3>
                                                <div class="timeline-body">
                                                    <p>
                                                        @if($claim->status == 'Accepted')
                                                            Congratulation! Your lost pet claim request has been <strong>Accepted</strong> by
                                                        @elseif($claim->status == 'Pending')
                                                            You send a lost pet claim request to
                                                        @elseif($claim->status == 'Rejected')
                                                            Sorry, your lost pet claim request has been <strong>Rejected</strong> by
                                                        @endif
                                                        <a href="{{ route('users.show', $pet_shelter->id) }}"><strong>{{ ($pet_shelter->name) }}</strong></a><br>
                                                    </p>
                                                    <h6><strong>Request ID</strong></h6>
                                                    <p>
                                                        {{__($claim->id)}}
                                                    </p>
                                                    @if($claim->status == 'Pending')
                                                        <h6><strong>Request Information</strong></h6>
                                                        <p>
                                                            {{__($claim->other_information)}}
                                                        </p>
                                                    @elseif($claim->status == 'Accepted' || $claim->status == 'Rejected')
                                                        @if($claim->status == 'Accepted')
                                                            <h6><strong>Delivery Date</strong></h6>
                                                            <p>
                                                                {{__(date('d M Y',strtotime($claim->delivery_date)))}}
                                                            </p>
                                                        @endif
                                                        <h6><strong>Feedback</strong></h6>
                                                        <p>
                                                            @if($claim->feedback == NULL)
                                                                {{ __('-') }}
                                                            @else
                                                            {{ $claim->feedback }}
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="{{ route('lost-pet-claims.show', $claim->id) }}" class="btn btn-primary btn-sm">Read more</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div>
                                        <i class="far fa-clock bg-primary"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($user_request_adoptions->count() > 0)
                            <div class="tab-pane" id="adoption" role="tabpanel" aria-labelledby="adoptions-requests-tab">
                                <div class="timeline timeline-inverse">
                                    @php
                                        $new_date = $user_request_adoptions->first()->created_at;
                                    @endphp
                                    @foreach($user_request_adoptions as $adoption)
                                        @if($new_date > \Carbon\Carbon::createFromDate($adoption->created_at)->addDay())
                                            @php $new_date = $adoption->created_at; @endphp
                                        @endif
                                        @if($new_date == $adoption->created_at)
                                            <div class="time-label">
                                                <span class="bg-primary">
                                                  {{date('d M Y', strtotime($new_date))}}
                                                </span>
                                            </div>
                                        @endif
                                        <div>
                                            @if($adoption->status == 'Accepted')
                                                <i class="fas fa-check-circle bg-success"></i>
                                            @elseif($adoption->status == 'Pending')
                                                <i class="fas fa-spinner bg-gray"></i>
                                            @elseif($adoption->status == 'Rejected')
                                                <i class="fas fa-times bg-danger"></i>
                                            @endif
                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{ __(\Carbon\Carbon::createFromDate($adoption->created_at)->diffForHumans()) }}</span>
                                                <h3 class="timeline-header @if($adoption->status == 'Accepted') text-success @elseif($adoption->status == 'Pending') text-muted @elseif($adoption->status == 'Rejected') text-danger @endif">
                                                    <strong>Adoption {{ __($adoption->status) }}</strong>
                                                </h3>
                                                <div class="timeline-body">
                                                    <p>
                                                        @if($adoption->status == 'Accepted')
                                                            Congratulation! Your adoption request has been <strong>Accepted</strong> by
                                                        @elseif($adoption->status == 'Pending')
                                                            You send an adoption request to
                                                        @elseif($adoption->status == 'Rejected')
                                                            Sorry, your adoption request has been <strong>Rejected</strong> by
                                                        @endif
                                                        <a href="{{ route('users.show', $pet_shelter->id) }}"><strong>{{ ($pet_shelter->name) }}</strong></a><br>
                                                    </p>
                                                    <h6><strong>Request ID</strong></h6>
                                                    <p>
                                                        {{__($adoption->id)}}
                                                    </p>
                                                    @if($adoption->status == 'Pending')
                                                        <h6><strong>Request Information</strong></h6>
                                                        <p>
                                                            {{__($adoption->other_information)}}
                                                        </p>
                                                    @elseif($adoption->status == 'Accepted' || $adoption->status == 'Rejected')
                                                        @if($adoption->status == 'Accepted')
                                                            <h6><strong>Delivery Date</strong></h6>
                                                            <p>
                                                                {{__(date('d M Y',strtotime($adoption->delivery_date)))}}
                                                            </p>
                                                        @endif
                                                        <h6><strong>Feedback</strong></h6>
                                                        <p>
                                                            @if($adoption->feedback == NULL)
                                                                {{ __('-') }}
                                                            @else
                                                                {{ $adoption->feedback }}
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="{{ route('adoptions.show', $adoption->id) }}" class="btn btn-primary btn-sm">Read more</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div>
                                        <i class="far fa-clock bg-primary"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @elseif(Auth::user()->role == 'pet_shelter')
                            @if($adp > 0 || $clm > 0 || $accepted)
                            <div class="tab-pane fade" id="{{($id_tab)}}" role="tabpanel" aria-labelledby="adoptions-requests-tab">
                                <div class="row">
                                    @foreach($allData as $data)
                                    <div class="col-lg-3">
                                        <a class="btn" style="padding: 0" href="{{route($route_data, $data->id)}}">
                                            <div class="card card-widget widget-user">
                                                <div style="text-align: center">
                                                    @php
                                                    $users = DB::table('users')->where('id', '=', $data->user_id)->get();
                                                      $user = new \App\Models\User();
                                                        foreach ($users as $obj) {
                                                          $user = $obj;
                                                        }
                                                    @endphp
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
