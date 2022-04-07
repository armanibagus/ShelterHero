@extends('template')

@section('page-title')
    {{__('Donation Details')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Donation Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{Auth::user()->role == 'user' ? url('/user/home') : url('/pet-shelter/home')}}">Main Menu</a></li>
                        @if(auth()->user()->role === 'user')
                        <li class="breadcrumb-item"><a href="{{url('/donations')}}">Donation Requests</a></li>
                        @elseif(auth()->user()->role === 'pet_shelter')
                        <li class="breadcrumb-item"><a href="{{url('/donations')}}">Donation History</a></li>
                        @endif
                        <li class="breadcrumb-item active">Donation Details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @php
        $images = DB::table('donation_imgs')->latest()->get();
        /*$allDonates = DB::table('donates')->where('donation_id', '=', $donation->id)->get();*/
        $title = ''; $totalDonates = 0;
        foreach ($images as $image) {
          if($image->donation_id == $donation->id){
            $title = trim(str_replace("public/donation-img/","", $image->path));
            break;
          }
        }

        // get the remaining times of the donation
        $exp_date = \Carbon\Carbon::parse($donation->expiry_date);
        $remaining_times = \Carbon\Carbon::now()->diffForHumans($exp_date);

        // get the progress percentage
        $progress = $donation->amount_get / $donation->amount_need * 100;
    @endphp
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <img class=" img-fluid" src="{{ asset('storage/donation-img/'.$title) }}" alt="Donation main picture" style="border-radius: 2%; object-fit: cover">
                        <div class="card-body">
                            <h3 class="text-left"><strong>{{ __($donation->title) }}</strong></h3>
                            <p class="text-muted">
                                <strong class="text-lg text-success">@currency($donation->amount_get)</strong>
                                was collected out of @currency($donation->amount_need)
                            </p>
                            <div class="progress progress-xs mt-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item" style="border-bottom: 0; padding: 0">
                                    <span class="float-left text-muted">{{ __($totalDonates) }} donation(s)</span>
                                    <p class="float-right">{{ __($remaining_times) }} expiry date</p>
                                </li>
                            </ul>
                            @php
                                $act = ''; $btn = '';
                                if (Auth::user()->role == 'user') {
                                  $act = 'donates.create'; $btn = 'Donate';
                                }
                                else if (Auth::user()->role == 'pet_shelter') {
                                  $act = 'donates.index'; $btn = 'View Donations from Users';
                                }
                            @endphp
                            <form method="GET" action="{{route($act)}}">
                                <input id="donation_id" type="number" name="donation_id" value="{{$donation->id}}" readonly hidden required>
                                <button type="submit" class="btn btn-block btn-success">
                                    {{ __($btn) }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ __('Donation Information') }}</strong>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body mb-2">
                                    <h6 class="text-muted mb-3">Fundraiser</h6>
                                    <a href="@if(Auth::user()->role == 'user'){{ route('users.show', $donation->shelter_id) }} @elseif(Auth::user()->role == 'pet_shelter') {{ __('#') }}@endif">
                                        <div class="user-block">
                                            @php
                                                $users = DB::table('users')->where('id', '=', $donation->shelter_id)->get();
                                                  $user = new \App\Models\User();
                                                    foreach ($users as $obj) {
                                                      $user = $obj;
                                                    }
                                            @endphp
                                            @if($user->photo_title != NULL && $user->photo_path != NULL)
                                                @php
                                                    $title = trim(str_replace("public/profile-picture/","", $user->photo_path));
                                                @endphp
                                                <img class="img-circle img-bordered-sm" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="object-fit: cover;">
                                            @else
                                                <img class="img-circle img-bordered-sm" src="{{ asset('artefact/dist/img/unknown.png') }}" alt="User profile picture">
                                            @endif
                                            <span class="username" style="color:#000;">{{ __($donation->name) }}</span>
                                            <span class="description">Verified <i class="fas fa-check-circle text-primary"></i></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-muted"><i class="fas fa-crosshairs"></i> Purpose</h6>
                                    <p class="text-bold">{{ __($donation->purpose) }}</p>
                                    <hr>
                                    <h6 class="text-muted bolt mt-4"><i class="fas fa-hand-holding-heart"></i> Recipient</h6>
                                    <p class="text-bold">{{ __($donation->donation_recipient) }}</p>
                                    <hr class="mb-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ __('Description') }}</strong>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>{{ __($donation->description) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
