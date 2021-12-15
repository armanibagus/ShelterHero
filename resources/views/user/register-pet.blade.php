@extends('template')

@section('page-title')
    {{__('Register Pet')}}
@endsection

@section('content-wrapper')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Register Pet</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url('/user/home')}}">Main Menu</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Register Pet
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist" >

                                {{-- Form Tab Label --}}
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#pet-registration-form" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="true">Form</a>
                                </li>

                                {{-- History Tab Label --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#pet-registration-history" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">History</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-five-tabContent">
                                {{-- Form Tab --}}
                                <div class="tab-pane fade show active" id="pet-registration-form" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">

                                    <form method="POST" action="{{ route('pets.store') }}" accept-charset="utf-8" enctype="multipart/form-data">
                                    @php
                                        $users = DB::table('users')->paginate(5);
                                        $i = 0;
                                        foreach ($users as $user) {
                                          if ($user->role === 'pet_shelter') {
                                            ++$i;
                                          }
                                        }
                                    @endphp
                                        @if($i<1)
                                        <fieldset disabled>
                                        @endif
                                        @csrf

                                        {{-- user_id --}}
                                        <input id="user_id" type="number" class="form-control" name="user_id" placeholder="User ID" value="{{Auth::user()->id}}" required autocomplete="user_id" hidden>

                                        {{-- Nickname Form --}}
                                        <div class="form-group">
                                            <label id="nicknameLabel" class="mb-1">Nickname</label>

                                            <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" placeholder="Enter pet nickname" value="{{ old('nickname') }}" required autocomplete="nickname">

                                            @error('nickname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        {{-- Pet Type Form --}}
                                        <div class="form-group">
                                            <label id="petTypeLabel" class="mb-1">Pet Type</label>
                                            <select id="petType" type="text" name="petType" autocomplete="petType" class="form-control @error('petType') is-invalid @enderror" required>
                                                <option selected disabled value="" >---[Select one]---</option>
                                                <option value="Dog">Dog</option>
                                                <option value="Cat">Cat</option>
                                                <option value="Bird">Bird</option>
                                                <option value="Rabbit">Rabbit</option>
                                                <option value="Fish">Fish</option>
                                            </select>
                                        </div>

                                        {{-- Sex Form --}}
                                        <div class="form-group">
                                            <label id="sexLabel" class="mb-1">Sex</label>
                                            <select id="sex" type="text" name="sex" autocomplete="sex" class="form-control @error('sex') is-invalid @enderror" required>
                                                <option selected disabled value="">---[Select one]---</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>

                                        {{-- Age Form --}}
                                        <div class="form-group">
                                            <label id="ageLabel" class="mb-1">Age</label>
                                            <div class="input-group">
                                                <input id="age" type="number" class="form-control @error('age') is-invalid @enderror" name="age" placeholder="Enter pet age (in year)" value="{{ old('age') }}" required autocomplete="age">

                                                @error('age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Size Form --}}
                                        <div class="form-group">
                                            <label id="sizeLabel" class="mb-1">Size</label>
                                            <select id="size" type="text" name="size" autocomplete="size" class="form-control @error('sex') is-invalid @enderror" required>
                                                <option selected disabled value="" >---[Select one]---</option>
                                                <option value="small">Small</option>
                                                <option value="medium">Medium</option>
                                                <option value="large">Large</option>
                                            </select>
                                        </div>

                                        {{-- Weight Form --}}
                                        <div class="form-group">
                                            <label id="weightLabel" class="mb-1">Weight</label>
                                            <div class="input-group">
                                                <input id="weight" type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" name="weight" placeholder="Enter pet weight (in Kg)" value="{{ old('weight') }}" required autocomplete="weight">

                                                @error('weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Condition Form --}}
                                        <div class="form-group">
                                            <label id="conditionLabel" class="mb-1">Condition</label>
                                            <div class="input-group">
                                                <textarea id="condition" type="text" class="form-control @error('condition') is-invalid @enderror" name="condition" placeholder="Enter pet condition" required autocomplete="condition" rows="4">{{ old('condition') }}</textarea>

                                                @error('condition')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label id="petImages" class="mb-1">Pet Images</label>

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


                                         {{--Register button--}}
                                        <div>
                                            <button type="submit" class="btn btn-primary float-right">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    @if($i>0)
                                        </fieldset>
                                    @endif
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="pet-registration-history" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body table-responsive p-0">
                                        <table id="dataTable1" class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Nickname</th>
                                                <th class="text-center">Type</th>
                                                <th class="text-center">Shelter ID</th>
                                                <th>Status</th>
                                                <th class="text-center">Pick Up Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pets as $pet)
                                                @if($pet->user_id == Auth::user()->id)
                                                    <tr>
                                                        <td class="text-center" style="width: 1px !important;">{{$pet->id}}</td>
                                                        <td>{{$pet->nickname}}</td>
                                                        <td class="text-center">{{$pet->petType}}</td>
                                                        @php
                                                            $date = new \Carbon\Carbon($pet->created_at);
                                                            $expiredate = $date->addDays(3);
                                                        @endphp
                                                        <td class="text-center">
                                                            @if($pet->shelter_id == '' /*|| ($pet->status != 'Confirmed' && $expiredate < \Carbon\Carbon::today())*/)
                                                                {{'-'}}
                                                            @else
                                                                {{$pet->shelter_id}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($pet->status != 'Confirmed' && $expiredate < \Carbon\Carbon::today())
                                                                {{'Expired'}}
                                                            @else
                                                                {{$pet->status}}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($pet->pickUpDate == '' || $expiredate < \Carbon\Carbon::today())
                                                                {{'-'}}
                                                            @else
                                                                {{date('d-M-Y', strtotime($pet->pickUpDate))}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pet Shelters</h3>
                        </div>
                        <div class="card-body">
                            {{-- Pet Shelter --}}
                            <div class="card-body table-responsive p-0">
                                <table id="dataTable5" class="table table-head-fixed text-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Email Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $users = DB::table('users')->get();
                                    @endphp
                                    @foreach($users as $user)
                                        @if($user->role === 'pet_shelter')
                                            <tr>
                                                <td class="text-center">{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->phoneNumber}}</td>
                                                <td>{{$user->email}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
