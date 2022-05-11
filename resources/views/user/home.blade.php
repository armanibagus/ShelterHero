@extends('template')

@section('content-wrapper')
<div class="content-wrapper">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @php
        $donation = \App\Models\Donation::join('donation_imgs', 'donation_imgs.donation_id', '=', 'donations.id')
                    ->where([['donations.expiry_date', '>', \Carbon\Carbon::now()],
                             ['donation_imgs.type', '=', 'donation']])
                    ->select(['donations.*', 'donation_imgs.path'])->latest()->first();
        $donation_img_title = '';
        if($donation != NULL)
          $donation_img_title = trim(str_replace("public/donation-img/","", $donation->path));
        $new_pets = \App\Models\Pet::join('users', 'users.id', 'pets.shelter_id')
                    ->where([['pets.status', '=', 'Confirmed'],
                             ['pets.pickUpDate', '>', \Carbon\Carbon::now()->subDays(7)]])
                    ->select(['pets.*', 'users.name', 'users.address'])->latest()->get();
        $claims = DB::table('lost_pet_claims')->get();
        $lost_pets = \App\Http\Controllers\PetController::validatePets($new_pets, $claims);
        $old_pet = \App\Models\Pet::join('users', 'users.id', 'pets.shelter_id')
                    ->where([['pets.status', '=', 'Confirmed'],
                             ['pets.pickUpDate', '<', \Carbon\Carbon::now()->subDays(7)]])
                    ->select(['pets.*', 'users.name', 'users.address'])->latest()->get();
        $adoption = DB::table('adoptions')->get();
        $adopt_pets = \App\Http\Controllers\PetController::validatePets($old_pet, $adoption);
    @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Main Menu</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-transparent">
                    <h2 class="card-title text-bold text-lg text-center ml-auto mr-auto pr-3 pl-3" style="margin-top: -12px; background-color: #f4f6f9">{{ __('Find Your Lost Pet') }}</h2>
                    <div class="card-body row pb-0">
                        @if(count($lost_pets) > 0)
                            @php
                                $count_claim = 0;
                                foreach($lost_pets as $pet) {
                                  if ($count_claim < 2)
                                    $count_claim++;
                                  else
                                    break;
                            @endphp
                                <div class="col-md-6">
                                    <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="card card-widget widget-user">
                                            @php
                                                $pet_img = \App\Models\Image::where('pet_id', '=', $pet->id)->first();
                                                $title = '';
                                                if ($pet_img != NULL)
                                                  $title = trim(str_replace("public/images/","", $pet_img->path));
                                            @endphp
                                            <div style="text-align: center">
                                                <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                            </div>
                                            <div class="card-body text-center">
                                                <strong class="text-lg">{{$pet->nickname}}</strong>
                                                @if($pet->sex === 'Male')
                                                    <i class="nav-icon text-blue fas fa-mars"></i>
                                                @elseif($pet->sex === 'Female')
                                                    <i class="nav-icon text-pink fas fa-venus"></i>
                                                @endif
                                                <br>
                                                {{ __($pet->size) }} • {{ __($pet->petType) }}<br>
                                                <div class="text-muted text-sm">
                                                    {{$pet->address}}<br>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @php } @endphp
                        @else
                            <p class="text-center m-0 p-3">{{ __('No data available') }}</p>
                        @endif
                    </div>
                    <div class="p-0 text-center rounded">
                        <a class="btn btn-block" href="{{route('lost-pet-claims.index')}}">
                            <strong class="text-secondary">View More<i class="fas fa-arrow-right ml-2"></i></strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-transparent">
                    <h2 class="card-title text-bold text-lg text-center ml-auto mr-auto pr-3 pl-3" style="margin-top: -12px; background-color: #f4f6f9">{{ __('Adopt a Pet') }}</h2>
                    <div class="card-body row pb-0">
                        @if(count($adopt_pets) > 0)
                            @php
                                $count_adopt = 0;
                                foreach($adopt_pets as $pet) {
                                  if ($count_adopt < 2)
                                    $count_adopt++;
                                  else
                                    break;
                            @endphp
                                <div class="col-md-6">
                                    <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                                        <!-- Widget: user widget style 1 -->
                                        <div class="card card-widget widget-user">
                                            @php
                                                $pet_img = \App\Models\Image::where('pet_id', '=', $pet->id)->first();
                                                $title = '';
                                                if ($pet_img != NULL)
                                                  $title = trim(str_replace("public/images/","", $pet_img->path));
                                            @endphp
                                            <div style="text-align: center">
                                                <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                            </div>
                                            <div class="card-body text-center">
                                                <strong class="text-lg">{{$pet->nickname}}</strong>
                                                @if($pet->sex === 'Male')
                                                    <i class="nav-icon text-blue fas fa-mars"></i>
                                                @elseif($pet->sex === 'Female')
                                                    <i class="nav-icon text-pink fas fa-venus"></i>
                                                @endif
                                                <br>
                                                {{ __($pet->size) }} • {{ __($pet->petType) }}<br>
                                                <div class="text-muted text-sm">
                                                    {{$pet->address}}<br>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @php } @endphp
                        @else
                            <p class="text-center m-0 p-3">{{ __('No data available') }}</p>
                        @endif
                    </div>
                    <div class="p-0 text-center rounded">
                        <a class="btn btn-block" href="{{route('adoptions.index')}}">
                            <strong class="text-secondary">View More<i class="fas fa-arrow-right ml-2"></i></strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            @if($donation != NULL)
            <h2 class="card-title text-bold text-lg text-center float-none mt-3 mb-2">{{ __('Donation Request') }}</h2>
            <div class="card-body pt-0 row">
                <div class="col-md-6 align-self-center order-2 order-md-1">
                    <h2 class="card-title text-bold text-lg text-center float-none mt-2 mb-2">{{ __($donation->title) }}</h2>
                    <p class="text-center">{{ __($donation->description) }}</p>
                    <div class="text-center">
                        <a class="btn btn-success" href="{{ route('donations.show', $donation->id) }}">{{ __('Donate!') }}</a>
                    </div>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <img class="img-fluid mt-4" src="{{ asset('storage/donation-img/'.$donation_img_title) }}" alt="Donation main picture" style="object-fit: cover">
                </div>
            </div>
            <hr class="m-0">
            <div class="p-0 text-center rounded">
                <a class="btn btn-block" href="{{route('donations.index')}}">
                    <strong class="text-secondary">View More<i class="fas fa-arrow-right ml-2"></i></strong>
                </a>
            </div>
            @else
                <p class="text-center m-0 p-3">{{ __('No data available') }}</p>
            @endif
        </div>
        <!-- /.card -->
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
