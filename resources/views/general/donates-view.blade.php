@extends('template')

@section('page-title')
    {{__('Donations from Users')}}
@endsection

@section('content-wrapper')
    @php
        $donation_id = $_GET['donation_id'];
        $donation = DB::table('donations')->where('id', $donation_id)->first();
    @endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Donations from Users')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{Auth::user()->role == 'user' ? url('/user/home') : url('/pet-shelter/home')}}">Main Menu</a></li>
                        @if(Auth::user()->role == 'pet_shelter')
                            <li class="breadcrumb-item"><a href="{{url('/donations')}}">Donation History</a></li>
                            <li class="breadcrumb-item"><a href="{{route('donations.show', $donation->id)}}">Donation Details</a></li>
                            <li class="breadcrumb-item active">{{__('Donations from Users')}}</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row">
            @php
                foreach ($donates as $donate) {
                  if ($donate->donation_id == $donation->id) {
                    $images = DB::table('donation_imgs')->latest()->get();
                    $title = '';
                    foreach ($images as $image) {
                      if($image->donate_id == $donate->id){
                        $title = trim(str_replace("public/donation-img/","", $image->path));
                        break;
                      }
                    }
            @endphp
            <div class="col-lg-3">
                <a class="btn" style="padding: 0" href="@if($donate->status != 'Pending'){{route('donates.show', $donate->id)}} @else {{route('donates.edit', $donate->id)}}@endif">
                    <div class="card card-widget widget-user">
                        <div style="text-align: center">
                            <img src="{{ asset('storage/donation-img/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                        </div>
                        <div class="card-body text-center">
                            <strong class="text-lg">{{ __($donate->name) }}</strong>
                            <h6 class="text-sm text-muted">@currency($donate->donate_amount)</h6>
                            @if($donate->status == 'Pending')
                            <i class="fas fa-spinner text-secondary text-lg mt-1"></i><p class="text-secondary mb-1">{{ __($donate->status) }}</p>
                            @elseif($donate->status == 'Accepted')
                            <i class="fas fa-check-circle text-success text-lg mt-1"></i><p class="text-success mb-1">{{ __($donate->status) }}</p>
                            @elseif($donate->status == 'Rejected')
                            <i class="fas fa-times text-danger text-lg mt-1"></i><p class="text-danger mb-1">{{ __($donate->status) }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @php
              }
            }
        @endphp
        </div>
    </section>
</div>
@endsection
