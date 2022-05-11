@extends('template')

@section('page-title')
    @if($pet->status == 'Pending' || $pet->status == 'Picked Up')
        {{__('Pet Registration')}}
    @elseif($pet->status == 'Confirmed')
        {{__('Edit Pet Information')}}
    @endif
@endsection

@section('content-wrapper')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @php $pet->status == 'Confirmed' ? $edit = true : $edit = false; @endphp
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if($edit)
                            <h1>{{__('Edit Pet Information')}}</h1>
                        @else
                            <h1>{{__('Pet Registration')}}</h1>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                @if(Auth::user()->role == 'user')
                                    <a href="{{url('/user/home')}}">Main Menu</a>
                                @elseif(Auth::user()->role == 'volunteer')
                                    <a href="{{url('/volunteer/home')}}">Main Menu</a>
                                @elseif(Auth::user()->role == 'pet_shelter')
                                    <a href="{{url('/pet-shelter/home')}}">Main Menu</a>
                                @endif
                            </li>
                            @if($edit)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('pets.show', $pet->id) }}">Pet Details</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{__('Edit Pet Information')}}
                                </li>
                            @else
                                <li class="breadcrumb-item active">
                                    Pet Registration
                                </li>
                            @endif
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-8" style="margin: auto">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="display: block; margin: auto; width: 30%" alt="logo image">
                            <br>
                            <div class="card-header">
                                <h2 class="card-title text-bold text-lg text-center" style="float: none">
                                    @if($edit)
                                        {{__('Edit Pet Information')}}
                                    @else
                                        {{__('Pet Registration')}}
                                    @endif
                                </h2>
                            </div>
                            <div class="card-body">
                                <form id="form" method="POST" action="{{ route('pets.update', $pet->id) }}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @if(!$edit)
                                        <fieldset disabled>
                                    @endif
                                    <div class="form-group">
                                        <label id="nicknameLabel" for="nickname" class="mb-1">Nickname</label>
                                        <div class="input-group">
                                            <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" placeholder="Enter pet nickname" value="{{ $pet->nickname }}" required autocomplete="name">
                                            @error('nickname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="petTypeLabel" for="petType" class="mb-1">Pet Type</label>
                                        <select id="petType" type="text" name="petType" class="form-control @error('petType') is-invalid @enderror" required>
                                            <option selected disabled value="" >---[Select one]---</option>
                                            <option {{ $pet->petType == 'Dog' ? 'selected' : '' }} value="{{ Crypt::encrypt('Dog') }}">Dog</option>
                                            <option {{ $pet->petType == 'Cat' ? 'selected' : '' }} value="{{ Crypt::encrypt('Cat') }}">Cat</option>
                                            <option {{ $pet->petType == 'Bird' ? 'selected' : '' }} value="{{ Crypt::encrypt('Bird') }}">Bird</option>
                                            <option {{ $pet->petType == 'Rabbit' ? 'selected' : '' }} value="{{ Crypt::encrypt('Rabbit') }}">Rabbit</option>
                                            <option {{ $pet->petType == 'Fish' ? 'selected' : '' }} value="{{ Crypt::encrypt('Fish') }}">Fish</option>
                                        </select>
                                        @error('petType')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="sexLabel" for="sex" class="mb-1">Sex</label>
                                        <select id="sex" type="text" name="sex" autocomplete="sex" class="form-control @error('sex') is-invalid @enderror" required>
                                            <option selected disabled value="">---[Select one]---</option>
                                            <option {{ $pet->sex == 'Male' ? 'selected' : '' }} value="{{ Crypt::encrypt('Male') }}">Male</option>
                                            <option {{ $pet->sex == 'Female' ? 'selected' : '' }} value="{{ Crypt::encrypt('Female') }}">Female</option>
                                        </select>
                                        @error('sex')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="ageLabel" for="age" class="mb-1">Age</label>
                                        <div class="input-group">
                                            <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age" placeholder="Enter pet age (in year)" value="{{ $pet->age }}" required autocomplete="age">
                                            @error('age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="sizeLabel" for="size" class="mb-1">Size</label>
                                        <select id="size" type="text" name="size" autocomplete="size" class="form-control @error('size') is-invalid @enderror" required>
                                            <option selected disabled value="" >---[Select one]---</option>
                                            <option {{ $pet->size == 'Small' ? 'selected' : '' }} value="{{ Crypt::encrypt('Small') }}">Small</option>
                                            <option {{ $pet->size == 'Medium' ? 'selected' : '' }} value="{{ Crypt::encrypt('Medium') }}">Medium</option>
                                            <option {{ $pet->size == 'Large' ? 'selected' : '' }} value="{{ Crypt::encrypt('Large') }}">Large</option>
                                        </select>
                                        @error('size')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="weightLabel" for="weight" class="mb-1">Weight</label>
                                        <div class="input-group">
                                            <input id="weight" type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" name="weight" placeholder="Enter pet weight (in Kg)" value="{{ $pet->weight }}" required autocomplete="weight">
                                            @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="conditionLabel" for="condition" class="mb-1">Condition</label>
                                        <div class="input-group">
                                            <textarea id="condition" type="text" class="form-control @error('condition') is-invalid @enderror" name="condition" placeholder="Enter pet condition" required autocomplete="condition" rows="4">{{ $pet->condition }}</textarea>
                                            @error('condition')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <label id="pet-images-label" class="mb-1">Update Pet Image(s)</label>
                                    @php
                                        $images = DB::table('images')->where('pet_id', '=', $pet->id)->get();
                                        $title = '';
                                        foreach ($images as $image){
                                            $title = trim(str_replace("public/images/","", $image->path));
                                    @endphp
                                        <img src="{{ asset('storage/images/'.$title) }}" style="width: 50%; border-radius: 2%; display: block; margin-left: auto; margin-right: auto;" ><br>
                                    @php
                                        }
                                    @endphp
                                    @if($edit)
                                    <div class="form-group">
                                        <small class="text-muted">If you want to change your pet's image(s), select image(s) by clicking the form below.</small>
                                        <div class="custom-file">
                                            <input id="images" type="file" name="images[]" class="custom-file-input @error('images') is-invalid @enderror" placeholder="Choose images" multiple>
                                            <label class="custom-file-label" for="customFile">Choose images</label>
                                            @error('images')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mt-1 text-center">
                                                    <div class="images-preview-div"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if(!$edit)
                                        </fieldset>
                                    @endif
                                    @if($pet->pickUpDate == NULL)
                                    <div class="form-group">
                                        <label id="picUpLabel" for="pickUpDate" class="mb-1">Pick Up Date</label>
                                        <div class="input-group">
                                            <input id="pickUpDate" type="date" class="form-control" name="pickUpDate" placeholder="Enter pick up date" value="{{ old('pickUpDate') }}" required>
                                            @error('pickUpDate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                    <button id="edit-btn" type="submit" class="btn btn-success float-right">
                                        @if($pet->status === 'Pending')
                                            {{ __('Pick Up') }}
                                        @elseif($pet->status === 'Picked Up')
                                            {{ __('Confirm') }}
                                        @elseif($pet->status === 'Confirmed')
                                            {{ __('Update') }}
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

