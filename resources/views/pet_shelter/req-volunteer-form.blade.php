@extends('template')

@section('page-title')
    {{__('Request Volunteer Form')}}
@endsection

@section('content-wrapper')
    @php
        $user_id = $_GET['user_id'];
        $user = DB::table('users')->where('id', $user_id)->first();
    @endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Request Volunteer Form') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/pet-shelter/home')}}">Main Menu</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Request Volunteer</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('users.show', $user->id)}}">Volunteer Details</a></li>
                        <li class="breadcrumb-item active">Request Volunteer Form</li>
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
                            <h2 class="card-title text-bold text-lg text-center" style="float: none">Request Volunteer Form</h2>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('health-checks.store')}}">
                                @if($total_volunteer < 1 || count($total_pet_owned) < 1)
                                <fieldset disabled>
                                @endif
                                    @csrf
                                    <input id="volunteer_id" type="hidden" class="form-control" name="volunteer_id" value="{{ Crypt::encrypt($user->id) }}" required hidden readonly>
                                    <div class="form-group">
                                        <label for="checkup-date" class="mb-1">Proposed Checkup Date</label>
                                        <input id="checkup-date" type="date" class="form-control @error('checkup_date') is-invalid @enderror" name="checkup_date" value="{{ old('checkup_date') }}" required>
                                        @error('checkup_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="select-pet" class="mb-1">Pet to be Examined</label>
                                        <select type="text" class="form-control @error('pet_id') is-invalid @enderror" required id="select-pet" name="pet_id">
                                            <option selected disabled value=""> ---[Select One]--- </option>
                                            @foreach($total_pet_owned as $pet)
                                            <option value="{{ Crypt::encrypt($pet->id) }}">{{ $pet->id .' - '. $pet->nickname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="mb-1">Description</label>
                                        <div class="input-group">
                                            <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Type here..." required rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Submit') }}
                                    </button>
                                @if($total_volunteer < 1 || count($total_pet_owned) < 1)
                                </fieldset>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
