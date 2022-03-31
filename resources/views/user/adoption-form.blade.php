@extends('template')

@section('page-title')
    {{__('Request Adoption Form')}}
@endsection

@section('content-wrapper')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @php
        $pet_id = $_GET['pet_id'];
        $pet = DB::table('pets')->where('id', $pet_id)->first();
    @endphp

    <style>
        #hidden_div {
            display: none;
        }
        #hidden_div2 {
            display: none;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Request Adoption Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/user/home')}}">Main Menu</a></li>
                            <li class="breadcrumb-item"><a href="{{route('adoptions.index')}}">Pet Adoption</a></li>
                            <li class="breadcrumb-item"><a href="{{route('pets.show', $pet->id)}}">Pet Details</a></li>
                            <li class="breadcrumb-item active">Request Adoption Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-8" style="margin: auto">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="display: block; margin: auto; width: 30%" alt="logo image">
                            <br>
                            <div class="card-header">
                                <h2 class="card-title text-bold text-lg text-center" style="float: none">Adoption Application Form</h2>
                            </div>
                            <div class="card-body">
                                {{-- adoption form --}}
                                <form method="POST" action="{{route('adoptions.store')}}">
                                    @php
                                        $users = DB::table('users')->get();
                                        $i = 0;
                                        foreach ($users as $user) {
                                          if ($user->role === 'user') {
                                            ++$i;
                                          }
                                        }

                                        $age = \Carbon\Carbon::parse(Auth::user()->dateOfBirth)->diff(\Carbon\Carbon::today())->y;
                                    @endphp
                                    @if($i<1)
                                        <fieldset disabled>
                                            @endif
                                            @csrf

                                            {{-- user_id --}}
                                            <input id="user_id" type="number" class="form-control" name="user_id" placeholder="User ID" value="{{Auth::user()->id}}" required hidden readonly>
                                            {{-- shelter_id --}}
                                            <input id="shelter_id" type="number" class="form-control" name="shelter_id" placeholder="Shelter ID" value="{{$pet->shelter_id}}" required hidden readonly>
                                            {{-- pet_id --}}
                                            <input id="pet_id" type="number" class="form-control" name="pet_id" placeholder="Pet ID" value="{{$pet->id}}" required hidden readonly>

                                            {{-- Identity Number Field --}}
                                            <div class="form-group">
                                                <label id="identityLabel" class="mb-1">Identity Number</label>
                                                <input id="user_idNumber" type="text" class="form-control @error('user_idNumber') is-invalid @enderror" name="user_idNumber" placeholder="Enter identity number" value="{{ Auth::user()->identityNumber }}" required>

                                                @error('user_idNumber')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Prospective Pet Parent Field --}}
                                            <div class="form-group">
                                                <label id="petParentLabel" class="mb-1">Prospective Pet Parent</label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{Auth::user()->name}}" required autocomplete="name">

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Adopter Age Field --}}
                                            <div class="form-group">
                                                <label id="adopterAgeLabel" class="mb-1">Age</label>
                                                <input id="adopter_age" type="text" class="form-control @error('adopter_age') is-invalid @enderror" name="adopter_age" placeholder="Age" value="{{ $age }}" required>

                                                @error('adopter_age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Adopter Email Field --}}
                                            <div class="form-group">
                                                <label class="mb-1">Email Address</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ Auth::user()->email }}" required autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Adopter Phone Number Field --}}
                                            <div class="form-group">
                                                <label class="mb-1">Phone Number</label>
                                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="+62 8xx-xxxx-xxxx" value="{{ Auth::user()->phoneNumber }}" required autocomplete="tel">

                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Adopter Address Field --}}
                                            <div class="form-group">
                                                <label class="mb-1">Street Address</label>
                                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Enter street address" value="{{ Auth::user()->address }}" required autocomplete="street-address">

                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="mb-1">City</label>
                                                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="Enter city" value="{{ old('city') }}" required autocomplete="address-level2">

                                                        @error('city')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="mb-1">State</label>
                                                        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" placeholder="Enter state" value="{{ old('state') }}" required autocomplete="address-level1">

                                                        @error('state')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="mb-1">Country</label>
                                                        <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" placeholder="Enter country" value="{{ old('country') }}" required autocomplete="country-name">

                                                        @error('country')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="mb-1">Postal Code</label>
                                                        <input id="postal" type="text" class="form-control @error('postal') is-invalid @enderror" name="postal" placeholder="Enter postal code" value="{{ old('postal') }}" required autocomplete="postal-code">

                                                        @error('postal')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Occupation Field --}}
                                            <div class="form-group">
                                                <label id="occupationLabel" class="mb-1">Occupation</label>

                                                <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" placeholder="Enter occupation" value="{{ old('occupation') }}" required>

                                                @error('occupation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Salary Field --}}
                                            <div class="form-group">
                                                <label id="salaryLabel" class="mb-1">Salary</label>

                                                <input id="salary" type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" name="salary" placeholder="Enter salary per month ($)" value="{{ old('salary') }}" required>

                                                @error('salary')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Number of Pets Owned Field --}}
                                            <div class="form-group">
                                                <label id="noOfPetOwnedLabel" class="mb-1">Number of Pet Owned</label>

                                                <input id="no_of_pet_owned" type="number" class="form-control @error('no_of_pet_owned') is-invalid @enderror" name="no_of_pet_owned" placeholder="Enter number of pet owned" value="{{ old('no_of_pet_owned') }}" required>

                                                @error('no_of_pet_owned')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Pets description Field  --}}
                                            <div class="form-group">
                                                <label id="petsDescriptionLabel" class="mb-1">Description of Pet(s) Owned</label>
                                                <div class="input-group">
                                                    <textarea id="pets_description" type="text" class="form-control @error('pets_description') is-invalid @enderror" name="pets_description" placeholder="Name(s), Breeds/Types, and Description/Behaviour" required rows="4">{{ old('pets_description') }}</textarea>

                                                    @error('pets_description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Home Question Radio --}}
                                            <div class="form-group">
                                                <label id="homeQuestionLabel" class="mb-1">Do you own or rent your home?</label>
                                                <div class="col-sm-6">
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary1" onchange="hideDiv(this)" name="home_question" value="Owned">
                                                            <label for="radioPrimary1" style="font-weight: 400!important; min-height: 30px!important;">
                                                                Owned
                                                            </label>
                                                        </div>
                                                        <br>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary2" onchange="showDiv(this)" name="home_question" value="Rent">
                                                            <label for="radioPrimary2" style="font-weight: 400!important;">
                                                                Rent
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @error('home_question')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div id="hidden_div">
                                                {{-- Rent Time Field --}}
                                                <div class="form-group">
                                                    <label id="rentTimeLabel" class="mb-1">If renting, how long at this address?</label>
                                                    <input id="rent_time" type="text" class="form-control @error('rent_time') is-invalid @enderror" name="rent_time" placeholder="Enter rent time" value="{{ old('rent_time') }}">

                                                    @error('rent_time')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                {{-- Animal Permission Radio --}}
                                                <div class="form-group">
                                                    <label id="animalPermissionLabel" class="mb-1">If you rent, do you have permission for an animal?</label>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary3" name="animal_permission" value="Yes">
                                                            <label for="radioPrimary3" style="font-weight: 400!important; min-height: 30px!important;">
                                                                Yes
                                                            </label>
                                                        </div>
                                                        <br>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary4" name="animal_permission" value="No">
                                                            <label for="radioPrimary4" style="font-weight: 400!important; min-height: 30px!important;">
                                                                No
                                                            </label>
                                                        </div>
                                                        <br>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary5" name="animal_permission" value="I have applied and am waiting on approval">
                                                            <label for="radioPrimary5" style="font-weight: 400!important;">
                                                                I have applied and am waiting on approval
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Rehomed Radio --}}
                                            <div class="form-group">
                                                <label id="rehomedQuestionLabel" class="mb-1">Have you ever surrendered or rehomed a pet?</label>
                                                <div class="col-sm-6">
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary6" onchange="showDiv2(this)" name="rehomed_question" value="Yes">
                                                            <label for="radioPrimary6" style="font-weight: 400!important; min-height: 30px!important;">
                                                                Yes
                                                            </label>
                                                        </div>
                                                        <br>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="radioPrimary7" onchange="hideDiv2(this)" name="rehomed_question" value="No">
                                                            <label for="radioPrimary7" style="font-weight: 400!important;">
                                                                No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Rehomed Description Field  --}}
                                            <div id="hidden_div2" class="form-group">
                                                <label id="rehomedDescriptionLabel" class="mb-1">If yes, please describe circumstances</label>
                                                <div class="input-group">
                                                    <textarea id="rehomed_description" type="text" class="form-control @error('rehomed_description') is-invalid @enderror" name="rehomed_description" placeholder="Type here..." rows="4">{{ old('rehomed_description') }}</textarea>

                                                    @error('rehomed_description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Family Member(s) Field --}}
                                            <div class="form-group">
                                                <label id="familyMemberLabel" class="mb-1">Who else lives in the home? (please list ages of all members)</label>
                                                <input id="family_member" type="text" class="form-control @error('family_member') is-invalid @enderror" name="family_member" placeholder="Enter all members" value="{{ old('family_member') }}" required>

                                                @error('family_member')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            {{-- Other Information Field  --}}
                                            <div class="form-group">
                                                <label id="otherInformationLabel" class="mb-1">Any other information that might help us determine your suitability for adoption?</label>
                                                <div class="input-group">
                                                    <textarea id="other_information" type="text" class="form-control @error('other_information') is-invalid @enderror" name="other_information" placeholder="Type here..." required rows="4">{{ old('other_information') }}</textarea>

                                                    @error('other_information')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Button --}}
                                                <button type="submit" class="btn btn-primary float-right">
                                                    {{ __('Submit') }}
                                                </button>
                                            @if($i<1)
                                        </fieldset>
                                    @endif
                                </form>
                                </div>
                            </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
<script>
    function showDiv(radio) {
        if (radio.checked) {
            document.getElementById("hidden_div").style.display = "block";
            document.getElementById('rent_time').setAttribute("required", "");
        }
    }
    function hideDiv(radio) {
        if (radio.checked) {
            document.getElementById("hidden_div").style.display = "none";
            document.getElementById('rent_time').removeAttribute("required");
        }
    }
    function showDiv2(radio) {
        if (radio.checked) {
            document.getElementById("hidden_div2").style.display = "block";
            document.getElementById('rehomed_description').setAttribute("required", "");
        }
    }
    function hideDiv2(radio) {
        if (radio.checked) {
            document.getElementById("hidden_div2").style.display = "none";
            document.getElementById('rehomed_description').removeAttribute("required");
        }
    }
</script>
@endsection
