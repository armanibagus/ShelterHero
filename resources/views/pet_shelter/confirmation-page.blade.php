@extends('template')

@section('page-title')
    @if(Request::is('adoptions/*/edit') || Request::is('adoptions/*'))
        {{__('Adoption Details')}}
    @elseif(Request::is('lost-pet-claims/*/edit') || Request::is('lost-pet-claims/*'))
        {{__('Claim Details')}}
    @endif
@endsection

@section('content-wrapper')
    <style>
        #hidden_div {
            display: none;
        }
    </style>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            @if(Request::is('adoptions/*/edit') || Request::is('adoptions/*'))
                                {{__('Adoption Details')}}
                            @elseif(Request::is('lost-pet-claims/*/edit') || Request::is('lost-pet-claims/*'))
                                {{__('Claim Details')}}
                            @endif
                        </h1>
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
                            @if(Auth::user()->role == 'pet_shelter')
                                @if($data->status == 'Pending')
                                    @if(Request::is('adoptions/*/edit'))
                                        <li class="breadcrumb-item"><a href="{{route('adoptions.index')}}">Adoption Request</a></li>
                                    @elseif(Request::is('lost-pet-claims/*/edit'))
                                        <li class="breadcrumb-item"><a href="{{route('lost-pet-claims.index')}}">Lost Pet Claim</a></li>
                                    @endif
                                @elseif($data->status == 'Accepted')
                                    <li class="breadcrumb-item"><a href="{{route('pets.myPets')}}">My Pets</a></li>
                                @endif
                            @endif
                            <li class="breadcrumb-item"><a href="{{route('pets.show', $data->pet_id)}}">Pet Details</a></li>
                            <li class="breadcrumb-item active">
                                @if(Request::is('adoptions/*/edit') || Request::is('adoptions/*'))
                                    {{__('Adoption Details')}}
                                @elseif(Request::is('lost-pet-claims/*/edit') || Request::is('lost-pet-claims/*'))
                                    {{__('Claim Details')}}
                                @endif
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
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
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 100px; width: 100px; object-fit: cover;">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                    @endif
                                </div>
                                <h3 class="profile-username text-center"><strong>{{__($data->name)}}</strong></h3>
                                @if((Request::is('adoptions/*/edit') && Auth::user()->role == 'pet_shelter') || (Request::is('adoptions/*') && Auth::user()->role == 'user'))
                                <p class="text-muted text-center">{{__($data->occupation)}}</p>
                                @endif
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>ID Number</b> <a class="text-muted float-right">{{__($data->user_idNumber)}}</a>
                                    </li>
                                    @if((Request::is('adoptions/*/edit') && Auth::user()->role == 'pet_shelter') || (Request::is('adoptions/*') && Auth::user()->role == 'user'))
                                        <li class="list-group-item">
                                            <strong>Age</strong> <a class="text-muted float-right">{{__($data->adopter_age)}} year(s) old</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Salary</b> <a class="text-muted float-right">${{__($data->salary)}}/month</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Contact Me</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <strong><i class="fas fa-phone-square-alt mr-1"></i> Phone Number</strong>
                                <p class="text-muted">{{__($data->phone)}}</p>

                                <hr>

                                <strong><i class="fas fa-envelope mr-1"></i> Email Address</strong>
                                <p class="text-muted">{{__($data->email)}}</p>

                                <hr>

                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                                <p class="text-muted">
                                    {{__($data->postal)}} | {{__($data->address)}} | {{__($data->city)}} |
                                    {{__($data->state)}} | {{__($data->country)}}
                                </p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-lg text-bold">{{__((Request::is('adoptions/*/edit') && Auth::user()->role == 'pet_shelter') || (Request::is('adoptions/*') && Auth::user()->role == 'user') ? 'Adoption Information' : 'Claim Information')}}</h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-12">
                                    @if((Request::is('adoptions/*/edit') && Auth::user()->role == 'pet_shelter') || (Request::is('adoptions/*') && Auth::user()->role == 'user'))
                                    <h6><strong>Number of Pets Owned</strong></h6>
                                    <p>
                                        {{__($data->no_of_pet_owned)}} Pet(s)
                                    </p>
                                    <hr>
                                    <h6><strong>Pet(s) Description</strong></h6>
                                    <p>
                                        {{__($data->pets_description)}}
                                    </p>
                                    <hr>
                                    <h6><strong>Type of Home Ownership</strong></h6>
                                    <p>
                                        {{__($data->home_question)}}
                                    </p>
                                    <hr>
                                    @if($data->home_question == 'Rent')
                                        <h6><strong>Rent Time</strong></h6>
                                        <p>
                                            {{__($data->rent_time)}}
                                        </p>
                                        <hr>
                                        <h6><strong>Animal Permission</strong></h6>
                                        <p>
                                            @if($data->animal_permission == 'Yes')
                                                {{__('Allowed')}}
                                            @elseif($data->animal_permission == 'No')
                                                {{__('Forbidden')}}
                                            @else
                                                {{__($data->animal_permission)}}
                                            @endif
                                        </p>
                                        <hr>
                                    @endif
                                    <h6><strong>Have you ever surrendered or rehomed a pet?</strong></h6>
                                    <p>
                                        {{__($data->rehomed_question)}}
                                    </p>
                                    <hr>
                                    @if($data->rehomed_question == 'Yes')
                                        <h6><strong>Description About Circumstances</strong></h6>
                                        <p>
                                            {{__($data->rehomed_description)}}
                                        </p>
                                        <hr>
                                    @endif
                                    <h6><strong>Family Member(s)</strong></h6>
                                    <p>
                                        {{__($data->family_member)}}
                                    </p>
                                    <hr>
                                    @elseif((Request::is('lost-pet-claims/*/edit') && Auth::user()->role == 'pet_shelter') || (Request::is('lost-pet-claims/*') && Auth::user()->role == 'user'))
                                        <h6><strong>Proof of Image</strong></h6>
                                        @php
                                            $images = DB::table('claim_images')->where('claim_id', '=', $data->id)->get();
                                            $title = '';
                                            foreach ($images as $image) {
                                              if($image->type == 'proof_of_img') {
                                                $title = trim(str_replace("public/pet-claim-img/","", $image->path));
                                        @endphp
                                            <img src="{{ asset('storage/pet-claim-img/'.$title) }}" class="img-fluid" alt="Responsive image">
                                        @php
                                              }
                                            }
                                        @endphp
                                        <hr>
                                        @php
                                            $BC = 0; $AC = 0;
                                            foreach ($images as $image) {
                                              if($image->type == 'birth_certificate_img') {
                                                $BC = 1;
                                              } else if ($image->type == 'appropriate_img') {
                                                $AC = 1;
                                              }
                                            }
                                        @endphp
                                        @if($BC > 0)
                                            <h6><strong>Birth Certificate</strong></h6>
                                            @php
                                                $images = DB::table('claim_images')->where('claim_id', '=', $data->id)->get();
                                                $title = '';
                                                foreach ($images as $image) {
                                                  if($image->type == 'birth_certificate_img') {
                                                    $title = trim(str_replace("public/pet-claim-img/","", $image->path));
                                            @endphp
                                                <img src="{{ asset('storage/pet-claim-img/'.$title) }}" class="img-fluid" alt="Responsive image">
                                            @php
                                                  }
                                                }
                                            @endphp
                                            <hr>
                                        @endif
                                        @if($AC > 0)
                                            <h6><strong>Appropriate Certificate</strong></h6>
                                            @php
                                                $images = DB::table('claim_images')->where('claim_id', '=', $data->id)->get();
                                                $title = '';
                                                foreach ($images as $image) {
                                                  if($image->type == 'appropriate_img') {
                                                    $title = trim(str_replace("public/pet-claim-img/","", $image->path));
                                            @endphp
                                            <img src="{{ asset('storage/pet-claim-img/'.$title) }}" class="img-fluid" alt="Responsive image">
                                            @php
                                                  }
                                                }
                                            @endphp
                                            <hr>
                                        @endif
                                    @endif
                                    <h6><strong>Other Information</strong></h6>
                                    <p>
                                        {{__($data->other_information)}}
                                    </p>
                                    <hr>
                                    <h6><strong>Status</strong></h6>
                                    @if($data->status == 'Accepted')
                                    <p class="text-success">
                                        <i class="fas fa-check-circle"></i>
                                    @elseif($data->status == 'Pending')
                                    <p class="text-gray">
                                        <i class="fas fa-spinner"></i>
                                    @elseif($data->status == 'Rejected')
                                    <p class="text-danger">
                                        <i class="fas fa-times"></i>
                                    @endif
                                         {{__($data->status)}}
                                    </p>
                                    <hr>
                                    @if($data->status == 'Accepted')
                                        <h6><strong>Delivery Date</strong></h6>
                                        <p>
                                            {{__(date('d M Y',strtotime($data->delivery_date)))}}
                                        </p>
                                        <hr>
                                    @endif
                                    @if($data->status != 'Pending' && $data->feedback != NULL)
                                        <h6><strong>Feedback</strong></h6>
                                        <p>
                                            {{__($data->feedback)}}
                                        </p>
                                        <hr>
                                    @endif
                                    @if($data->status == 'Pending' && Auth::user()->role == 'pet_shelter' && (Request::is('adoptions/*/edit') || Request::is('lost-pet-claims/*/edit')))
                                    <form method="POST" action="@if(Request::is('adoptions/*/edit')){{route('adoptions.update', $data->id)}}@elseif(Request::is('lost-pet-claims/*/edit')){{route('lost-pet-claims.update', $data->id)}}@endif">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label id="deliveryDateLabel" class="mb-1">Status</label>
                                            <select id="status" type="text" name="status" class="form-control @error('status') is-invalid @enderror" required onchange="showDiv(this)">
                                                <option selected disabled value="" >---[Select one]---</option>
                                                <option value="Accepted">Accepted</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>
                                        <div id="hidden_div" class="form-group">
                                            <label id="deliveryDateLabel" class="mb-1">Delivery Date</label>
                                            <div class="input-group">
                                                <input id="delivery_date" type="date" class="form-control" name="delivery_date" placeholder="Enter delivery date" value="{{old('delivery_date')}}">

                                                @error('delivery_date')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label id="feedbackLabel" class="mb-1">Feedback</label>
                                            <div class="input-group">
                                                <textarea id="feedback" type="text" class="form-control @error('feedback') is-invalid @enderror" name="feedback" placeholder="Type here..." required rows="4">{{ old('feedback') }}</textarea>

                                                @error('feedback')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right">
                                            {{ __('Submit') }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        function showDiv(select)
        {
            if (select.value === 'Accepted') {
                document.getElementById('hidden_div').style.display = "block";
                document.getElementById('delivery_date').setAttribute("required", "");
            }
            else {
                document.getElementById('hidden_div').style.display = "none";
                document.getElementById('delivery_date').removeAttribute("required");
            }
        }
    </script>
@endsection
