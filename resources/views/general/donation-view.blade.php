@extends('template')

@section('page-title')
    @if(Auth::user()->role == 'user')
        {{ __('Donation Requests') }}
    @elseif(Auth::user()->role == 'pet_shelter')
        {{ __('Donation History') }}
    @endif
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        @if(Auth::user()->role == 'user')
                            {{ __('Donation Requests') }}
                        @elseif(Auth::user()->role == 'pet_shelter')
                            {{ __('Donation History') }}
                        @endif
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{Auth::user()->role == 'user' ? url('/user/home') : url('/pet-shelter/home')}}">Main Menu</a></li>
                        @if(Auth::user()->role == 'user')
                        <li class="breadcrumb-item active">Donation Requests</li>
                        @elseif(Auth::user()->role == 'pet_shelter')
                            <li class="breadcrumb-item active">Donation History</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row">
            @foreach($allDonations as $donation)
                <div class="col-lg-3">
                    <a class="btn" style="padding: 0" href="{{route('donations.show', $donation->id)}}">
                        <div class="card card-widget widget-user">
                            @php
                                $images = DB::table('donation_imgs')->latest()->get();
                                $title = '';
                                foreach ($images as $image) {
                                  if($image->donation_id == $donation->id){
                                    $title = trim(str_replace("public/donation-img/","", $image->path));
                                    break;
                                  }
                                }

                                // get the progress percentage
                                $progress = $donation->amount_get / $donation->amount_need * 100;
                            @endphp
                            <div style="text-align: center">
                                <img src="{{ asset('storage/donation-img/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                            </div>
                            <div class="card-body text-left">
                                <strong class="text-lg">{{ __($donation->title) }}</strong><br>
                                {{ __($donation->name) }}<br>
                                <div class="progress progress-xs mt-3">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-sm text-right mb-0">Total donation <strong>@currency($donation->amount_get)</strong></p>
                            </div>
                            <div class="card-footer text-sm text-right text-muted" style="padding-top: 15px">
                                {{ __(\Carbon\Carbon::createFromDate($donation->expiry_date)->diffForHumans()) }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
