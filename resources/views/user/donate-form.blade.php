@extends('template')

@section('page-title')
    {{__('Donation Form')}}
@endsection

@section('content-wrapper')
    @php
        $donation_id = $_GET['donation_id'];
        $donation = DB::table('donations')->where('id', $donation_id)->first();
    @endphp
    <style>
        #hidden_div {
            display: none;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Donation Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/user/home')}}">Main Menu</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/donations')}}">Donation Requests</a></li>
                            <li class="breadcrumb-item"><a href="{{route('donations.show', $donation->id)}}">Donation Details</a></li>
                            <li class="breadcrumb-item active">Donation Form</li>
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
                                <h2 class="card-title text-bold text-lg text-center" style="float: none">Donation Form</h2>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{route('donates.store')}}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    <input id="donation_id" type="number" class="form-control" name="donation_id" value="{{ ($donation->id) }}" required hidden readonly>
                                    <input id="user_id" type="number" class="form-control" name="user_id" value="{{ (Auth::user()->id) }}" required hidden readonly>
                                    <div class="form-group">
                                        <label class="mb-1">Full Name</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter full name" value="{{ Auth::user()->name }}" required autocomplete="name">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1">Email Address</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ Auth::user()->email }}" required autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mb-1">Phone Number</label>
                                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="+62 8xx-xxxx-xxxx" value="{{ Auth::user()->phoneNumber }}" required autocomplete="tel">

                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="donate_amountLabel" class="mb-1">How much do you want to donate?</label>
                                        <input id="donate_amount" type="number" min="1" step="0.01" class="form-control @error('donate_amount') is-invalid @enderror" name="donate_amount" placeholder="USD $ 0.00" value="{{ old('donate_amount') }}" required>
                                        @error('donate_amount')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="commentLabel" class="mb-1">Leave us a comment</label>
                                        <div class="input-group">
                                            <textarea id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" placeholder="Type here..." required rows="4">{{ old('comment') }}</textarea>

                                            @error('comment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="payment_methodLabel" class="mb-1">Payment Method</label>
                                        <div class="col-sm-6">
                                            <div class="form-group clearfix">
                                                <div class="icheck-success d-inline">
                                                    <input type="radio" id="radioPrimary1" onchange="showDiv(this)" name="payment_method" value="Bank Transfer">
                                                    <label for="radioPrimary1" style="font-weight: 400!important; min-height: 30px!important;">
                                                        <i class="far fa-credit-card"></i> Bank Transfer
                                                    </label>
                                                </div>
                                            </div>
                                            @error('payment_method')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="hidden_div" class="form-group">
                                        <hr>
                                        <dl class="row">
                                            <dt class="col-sm-4" style="font-weight: 400">{{ __('Bank Name') }}</dt>
                                            <dd class="col-sm-8" >: <strong>{{ __($donation->bank_name) }}</strong></dd>
                                            <dt class="col-sm-4" style="font-weight: 400">{{ __('Account Name') }}</dt>
                                            <dd class="col-sm-8">: <strong>{{ __($donation->accountName) }}</strong></dd>
                                            <dt class="col-sm-4" style="font-weight: 400">{{ __('Account Number') }}</dt>
                                            <dd class="col-sm-8">: <strong>{{ __($donation->CCNumber) }}</strong></dd>
                                        </dl>
                                        <label id="receiptImages" class="mb-1">Upload Receipt</label>
                                        <div class="custom-file">
                                            <input id="receipt_img" type="file" name="receipt_img" class="custom-file-input @error('receipt_img') is-invalid @enderror" placeholder="Choose image" required>
                                            <label class="custom-file-label" for="customFile">Choose image</label>

                                            @error('receipt_img')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mt-1 text-center">
                                                    <div class="receipt_img-preview-div"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block float-right mt-2">
                                        {{ __('Donate') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function showDiv(radio) {
            if (radio.checked) {
                document.getElementById("hidden_div").style.display = "block";
            }
        }
    </script>
@endsection
