@extends('template')

@section('content-wrapper')
<div class="content-wrapper">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @php
        $register_pet = \App\Models\Pet::join('users', 'users.id', '=', 'pets.user_id')
                        ->select(['pets.*', 'users.name', 'users.address'])
                        ->where([['status', '=', 'Pending'], ['pickUpDate', '=', NULL]])
                        ->latest()->get();
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
        <div class="card bg-transparent">
            <h2 class="card-title text-bold text-lg text-center ml-auto mr-auto pr-3 pl-3" style="margin-top: -12px; background-color: #f4f6f9">{{ __('Help Them Find a Home') }}</h2>
            <div class="card-body row pb-0">
                @if(count($register_pet) > 0)
                    @php
                        $checks = 0;
                        foreach($register_pet as $pet) {
                          if ($checks < 4)
                            $checks++;
                          else
                            break;
                    @endphp
                    <div class="col-md-3">
                        <a class="btn" style="padding: 0" href="{{route('pets.edit', $pet->id)}}">
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
                <a class="btn btn-block" href="{{route('pets.viewPetRegis')}}">
                    <strong class="text-secondary">View More<i class="fas fa-arrow-right ml-2"></i></strong>
                </a>
            </div>
        </div>
        <div class="card">
            @if(count($register_pet) > 0)
                @php
                            $pet = $register_pet->first();
                @endphp
                <h2 class="card-title text-bold text-lg text-center float-none mt-4 mb-3">{{ __('Register Pet Information') }}</h2>
                <div class="card-body row ml-3 mr-3 mb-3 ">
                    <div class="col-md-6 align-self-center order-2 order-md-1">
                        <div class="row justify-content-center ">
                            <div class="col-md-6" style="border-left: 0.25rem solid #000">
                                <h6><strong>Nickname</strong></h6>
                                <p>
                                    {{ ($pet->nickname) }}
                                </p>
                                <hr>
                                <h6><strong>Type</strong></h6>
                                <p>
                                    {{ ($pet->petType) }}
                                </p>
                                <hr>
                                <h6><strong>Sex</strong></h6>
                                <p>
                                    {{ ($pet->sex) }}
                                </p>
                                <hr>
                                <h6><strong>Age</strong></h6>
                                <p>
                                    {{ ($pet->age) }}
                                </p>
                                <hr style="margin-bottom: 0!important;">
                            </div>
                            <div class="col-md-6" style="border-left: 0.25rem solid #000">
                                <h6><strong>Size</strong></h6>
                                <p>
                                    {{ ($pet->size) }}
                                </p>
                                <hr>
                                <h6><strong>Weight</strong></h6>
                                <p>
                                    {{ ($pet->weight) }}
                                </p>
                                <hr>
                                <h6><strong>Condition</strong></h6>
                                <p>
                                    {{ ($pet->condition) }}
                                </p>
                                <hr>
                                <h6><strong>Status</strong></h6>
                                @if($pet->status == 'Pending')
                                    <p class="text-secondary"><strong><i class="fas fa-spinner"></i> {{ __($pet->status) }}</strong></p>
                                @elseif($pet->status == 'Accepted')
                                    <p class="text-success"><strong><i class="fas fa-check-circle"></i> {{ __($pet->status) }}</strong></p>
                                @elseif($pet->status == 'Rejected')
                                    <p class="text-danger"><strong><i class="fas fa-times"></i> {{ __($pet->status) }}</strong></p>
                                @endif
                                <hr style="margin-bottom: 0!important;">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a class="btn btn-success" href="{{ route('pets.edit', $pet->id) }}">{{ __('Find out more') }}</a>
                        </div>
                    </div>
                    <div class="col-md-6 order-1 order-md-2 text-center mb-5">
                        @php
                            $pet_img = \App\Models\Image::where('pet_id', '=', $pet->id)->first();
                            $title = '';
                            if ($pet_img != NULL)
                              $title = trim(str_replace("public/images/","", $pet_img->path));
                        @endphp
                            <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                    </div>
                </div>
            @else
                <p class="text-center m-0 p-3">{{ __('No data available') }}</p>
            @endif
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
