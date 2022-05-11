@extends('template')

@section('page-title')
    {{__('Activity History')}}
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Activity History')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/volunteer/home')}}">Main Menu</a></li>
                            <li class="breadcrumb-item active">{{__('Activity History')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist" >
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#adoptions-tab" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="true">Adoptions</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#claims-tab" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Lost Pet Claims</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#donations-tab" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Donations</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-five-tabContent">
                                <div class="tab-pane fade show active" id="adoptions-tab" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body p-1 row @if($adoptions->count() < 1) justify-content-center @endif">
                                        @if($adoptions->count() > 0)
                                            @foreach($adoptions as $adopt)
                                                <div class="col-md-3">
                                                    <a class="btn" style="padding: 0" href="{{route('pets.show', $adopt->id)}}">
                                                        <div class="card card-widget widget-user">
                                                            @php
                                                                $images = DB::table('images')->get();
                                                                $title = '';
                                                                foreach ($images as $image)
                                                                  if($image->pet_id == $adopt->id){
                                                                    $title = trim(str_replace("public/images/","", $image->path));
                                                                    break;
                                                                  }
                                                                @endphp
                                                            <div style="text-align: center">
                                                                <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                                            </div>
                                                            <div class="card-body text-center">
                                                                <strong class="text-lg">{{$adopt->nickname}}</strong>
                                                                @if($adopt->sex === 'Male')
                                                                    <i class="nav-icon text-blue fas fa-mars"></i>
                                                                @elseif($adopt->sex === 'Female')
                                                                    <i class="nav-icon text-pink fas fa-venus"></i>
                                                                @endif
                                                                <br>
                                                                {{ __($adopt->size) }} • {{ __($adopt->petType) }}<br>
                                                                <div class="text-muted text-sm">
                                                                    {{$adopt->address}}<br>
                                                                </div>
                                                                @if($adopt->status == 'Pending')
                                                                    <i class="fas fa-spinner text-secondary text-lg mt-1"></i><p class="text-secondary mb-1">{{ __($adopt->status) }}</p>
                                                                @elseif($adopt->status == 'Accepted')
                                                                    <i class="fas fa-check-circle text-success text-lg mt-1"></i><p class="text-success mb-1">{{ __($adopt->status) }}</p>
                                                                @elseif($adopt->status == 'Rejected')
                                                                    <i class="fas fa-times text-danger text-lg mt-1"></i><p class="text-danger mb-1">{{ __($adopt->status) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No data available</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="claims-tab" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body p-1 row @if($lost_pet_claims->count() < 1) justify-content-center @endif">
                                        @if($lost_pet_claims->count() > 0)
                                            @foreach($lost_pet_claims as $claim)
                                                <div class="col-md-3">
                                                    <a class="btn" style="padding: 0" href="{{route('pets.show', $claim->id)}}">
                                                        <div class="card card-widget widget-user">
                                                            @php
                                                                $images = DB::table('images')->get();
                                                                $title = '';
                                                                foreach ($images as $image)
                                                                  if($image->pet_id == $claim->id){
                                                                    $title = trim(str_replace("public/images/","", $image->path));
                                                                    break;
                                                                  }
                                                            @endphp
                                                            <div style="text-align: center">
                                                                <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                                            </div>
                                                            <div class="card-body text-center">
                                                                <strong class="text-lg">{{$claim->nickname}}</strong>
                                                                @if($claim->sex === 'Male')
                                                                    <i class="nav-icon text-blue fas fa-mars"></i>
                                                                @elseif($claim->sex === 'Female')
                                                                    <i class="nav-icon text-pink fas fa-venus"></i>
                                                                @endif
                                                                <br>
                                                                {{ __($claim->size) }} • {{ __($claim->petType) }}<br>
                                                                <div class="text-muted text-sm">
                                                                    {{$claim->address}}<br>
                                                                </div>
                                                                @if($claim->status == 'Pending')
                                                                        <i class="fas fa-spinner text-secondary text-lg mt-1"></i><p class="text-secondary mb-1">{{ __($claim->status) }}</p>
                                                                @elseif($claim->status == 'Accepted')
                                                                    <i class="fas fa-check-circle text-success text-lg mt-1"></i><p class="text-success mb-1">{{ __($claim->status) }}</p>
                                                                @elseif($claim->status == 'Rejected')
                                                                    <i class="fas fa-times text-danger text-lg mt-1"></i><p class="text-danger mb-1">{{ __($claim->status) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No data available</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="donations-tab" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body p-1 row @if($donations->count() < 1) justify-content-center @endif">
                                        @if($donations->count() > 0)
                                            @foreach($donations as $donate)
                                                <div class="col-md-3">
                                                    <a class="btn" style="padding: 0" href="{{route('donates.show', $donate->id)}}">
                                                        <div class="card card-widget widget-user">
                                                            <div style="text-align: center">
                                                                <img src="{{ asset('storage/donation-img/'.trim(str_replace("public/donation-img/","", $donate->path))) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                                            </div>
                                                            <div class="card-body text-center">
                                                                <strong class="text-lg">{{ __($donate->title) }}</strong>
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
                                            @endforeach
                                        @else
                                            <p>No data available</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
