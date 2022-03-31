@extends('template')

@section('page-title')
    {{__('Lost Pet Claim Form')}}
@endsection

@section('content-wrapper')
    @php
        $pet_id = $_GET['pet_id'];
        $pet = DB::table('pets')->where('id', $pet_id)->first();
    @endphp
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lost Pet Claim Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/user/home')}}">Main Menu</a></li>
                            <li class="breadcrumb-item"><a href="{{route('lost-pet-claims.index')}}">Lost Pet Claim</a></li>
                            <li class="breadcrumb-item"><a href="{{route('pets.show', $pet->id)}}">Pet Details</a></li>
                            <li class="breadcrumb-item active">Lost Pet Claim Form</li>
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
                                <h2 class="card-title text-bold text-lg text-center" style="float: none">Lost Pet Claim Application Form</h2>
                            </div>
                            <div class="card-body">
                                {{-- adoption form --}}
                                <form method="POST" action="{{route('lost-pet-claims.store')}}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @php
                                        $users = DB::table('users')->get();
                                        $i = 0;
                                        foreach ($users as $user) {
                                          if ($user->role === 'user') {
                                            ++$i;
                                          }
                                        }
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

                                            <div class="form-group">
                                                <label id="petImages" class="mb-1">Proof of Image (E.g. Pet image)</label>
                                                <div class="custom-file">
                                                    <input id="proof_of_img" type="file" name="proof_of_img[]" class="custom-file-input @error('proof_of_img') is-invalid @enderror" placeholder="Choose images" multiple required>
                                                    <label class="custom-file-label" for="customFile">Choose images</label>

                                                    @error('proof_of_img')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mt-1 text-center">
                                                            <div class="proof_of_img-preview-div"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label id="birthCertifyImages" class="mb-1">Birth Certificate (If exist)</label>
                                                <div class="custom-file">
                                                    <input id="birth_certificate_img" type="file" name="birth_certificate_img[]" class="custom-file-input @error('birth_certificate_img') is-invalid @enderror" placeholder="Choose images" multiple>
                                                    <label class="custom-file-label" for="customFile">Choose image</label>

                                                    @error('birth_certificate_img')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mt-1 text-center">
                                                            <div class="birth_certificate_img-preview-div"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label id="appropriateImages" class="mb-1">Any Other Appropriate Certificate (If exist)</label>
                                                <div class="custom-file">
                                                    <input id="appropriate_img" type="file" name="appropriate_img[]" class="custom-file-input @error('appropriate_img') is-invalid @enderror" placeholder="Choose images" multiple>
                                                    <label class="custom-file-label" for="customFile">Choose images</label>

                                                    @error('appropriate_img')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mt-1 text-center">
                                                            <div class="appropriate_img-preview-div"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Other Information Field  --}}
                                            <div class="form-group">
                                                <label id="otherInformationLabel" class="mb-1">Any other information that might help us determine pet ownership?</label>
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
@endsection
