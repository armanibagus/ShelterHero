@extends('template')

@section('page-title')
    {{__('Open Donation')}}
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Open Donation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/pet-shelter/home')}}">Main Menu</a></li>
                            <li class="breadcrumb-item active">Open Donation</li>
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
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="display: block; margin: auto; width: 30%" alt="logo image">
                            <br>
                            <div class="card-header">
                                <h2 class="card-title text-bold text-lg text-center" style="float: none">Open Donation Form</h2>
                            </div>
                            <div class="card-body">
                                {{-- Form --}}
                                <form method="POST" action="{{route('donations.store')}}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    <input id="shelter_id" type="number" class="form-control" name="shelter_id" value="{{ (auth()->user()->id) }}" required hidden readonly>
                                    <div class="form-group">
                                        <label id="identityLabel" class="mb-1">Shelter License Number</label>
                                        <input id="user_idNumber" type="text" class="form-control @error('user_idNumber') is-invalid @enderror" name="user_idNumber" placeholder="Enter identity number" value="{{ Auth::user()->identityNumber }}" required>

                                        @error('user_idNumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="petParentLabel" class="mb-1">Organization/Shelter Name</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter organization/shelter name" value="{{Auth::user()->name}}" required autocomplete="name">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Email Address</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ Auth::user()->email }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1">Phone Number</label>
                                        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="+62 8xx-xxxx-xxxx" value="{{ Auth::user()->phoneNumber }}" required autocomplete="tel">

                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
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
                                    <hr>
                                    <label id="paymentMethodLabel" class="card-title mb-1" style="float: none">Bank Account</label>
                                    <div class="form-group">
                                        <label id="bank_nameLabel" class="mb-1">Bank Name</label>
                                        <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" placeholder="Enter bank name" value="{{ old('bank_name') }}" required>

                                        @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="accountNameLabel" class="mb-1">Name on Card</label>
                                        <input id="accountName" type="text" class="form-control @error('accountName') is-invalid @enderror" name="accountName" placeholder="Enter name on card" value="{{ old('accountName') }}" required autocomplete="cc-name">

                                        @error('accountName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="creditCardLabel" class="mb-1">Card Number</label>
                                        <input id="CCNumber" type="text" class="form-control @error('CCNumber') is-invalid @enderror" name="CCNumber" placeholder="Enter card no." value="{{ old('CCNumber') }}" required autocomplete="cc-number">
                                        @error('CCNumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label id="titleLabel" class="mb-1">What is the title of this donation request?</label>
                                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Enter title" value="{{ old('title') }}" required>

                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="amount_needLabel" class="mb-1">Total Amount Needed</label>
                                        <input id="amount_need" type="number" min="0" step="0.01" class="form-control @error('amount_need') is-invalid @enderror" name="amount_need" placeholder="USD $ 0.00" value="{{ old('amount_need') }}" required>
                                        @error('amount_need')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="expiry_dateLabel" class="mb-1">Donation Time Limit</label>
                                        <input id="expiry_date" type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('donation_time') }}" required>
                                        @error('expiry_date')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="purposeLabel" class="mb-1">Donation Purpose</label>
                                        <input id="purpose" type="text" class="form-control @error('purpose') is-invalid @enderror" name="purpose" placeholder="Enter donation purpose" value="{{ old('purpose') }}" required>

                                        @error('purpose')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="donation_recipientLabel" class="mb-1">Donation Recipient</label>
                                        <input id="donation_recipient" type="text" class="form-control @error('donation_recipient') is-invalid @enderror" name="donation_recipient" placeholder="Enter donation recipient" value="{{ old('donation_recipient') }}" required>

                                        @error('donation_recipient')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="descriptionLabel" class="mb-1">Description of the Donation (reason and use of funds)</label>
                                        <div class="input-group">
                                            <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Type here..." required rows="4">{{ old('description') }}</textarea>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="donationImages" class="mb-1">Choose a Photo for Your Donation Request</label>
                                        <div class="custom-file">
                                            <input id="donation_img" type="file" name="donation_img" class="custom-file-input @error('donation_img') is-invalid @enderror" placeholder="Choose image" required>
                                            <label class="custom-file-label" for="customFile">Choose image</label>

                                            @error('donation_img')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mt-1 text-center">
                                                    <div class="donation_img-preview-div"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Request') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
