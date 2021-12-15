@extends('template')

@section('page-title')
    {{__('Pet Registration')}}
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
                        <h1>Pet Registration</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url('/user/home')}}">Main Menu</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Pet Registration
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pet Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-five-tabContent">
                                {{-- Form Tab --}}
                                <div class="tab-pane fade show active" id="pet-registration-form" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <form method="POST" action="{{ route('pets.update', $pet->id) }}">
                                        @csrf
                                        @method('PUT')

                                        {{--user_id--}}
                                        <input id="user_id" type="number" class="form-control " name="user_id" placeholder="User ID" value="{{ $pet->user_id }}" hidden disabled>

                                        {{--shelter id--}}
                                        <input id="shelter_id" type="number" class="form-control" name="shelter_id" placeholder="Shelter ID" value="{{Auth::user()->id}}" hidden {{$pet->status === 'Pending' ? '' : 'disabled'}}>

                                        {{--Nickname Form --}}
                                        <div class="form-group">
                                            <label id="nicknameLabel" class="mb-1">Nickname</label>
                                            <input id="nickname" type="text" class="form-control" name="nickname" value="{{ $pet->nickname }}" disabled>

                                        </div>

                                        {{--Pet Type Form--}}
                                        <div class="form-group">
                                            <label id="petTypeLabel" class="mb-1">Pet Type</label>
                                            <input id="petType" type="text" name="petType" class="form-control" value="{{ $pet->petType }}" disabled>

                                        </div>

                                        {{--Sex Form--}}
                                        <div class="form-group">
                                            <label id="sexLabel" class="mb-1">Sex</label>
                                            <input id="sex" type="text" name="sex" class="form-control" value="{{ $pet->sex }}" disabled>

                                        </div>

                                        {{--Age Form--}}
                                        <div class="form-group">
                                            <label id="ageLabel" class="mb-1">Age</label>
                                            <div class="input-group">
                                                <input id="age" type="number" class="form-control" name="age" value="{{ $pet->age }}" disabled>

                                            </div>
                                        </div>

                                        {{--Size Form --}}
                                        <div class="form-group">
                                            <label id="sizeLabel" class="mb-1">Size</label>
                                            <input id="size" type="text" name="size" step="0.01" class="form-control"  value="{{ $pet->size }}" disabled>

                                        </div>

                                        {{--Weight Form --}}
                                        <div class="form-group">
                                            <label id="weightLabel" class="mb-1">Weight</label>
                                            <div class="input-group">
                                                <input id="weight" type="number" step="0.01" class="form-control" name="weight" value="{{ $pet->weight }}" disabled>

                                            </div>
                                        </div>

                                        {{--Condition Form --}}
                                        <div class="form-group">
                                            <label id="conditionLabel" class="mb-1">Condition</label>
                                            <div class="input-group">
                                                <textarea id="condition" type="text" class="form-control" name="condition" rows="4" disabled>{{ $pet->condition }}</textarea>

                                            </div>
                                        </div>
                                        <label id="picUpLabel" class="mb-1">Pet Images</label>
                                        @php
                                            $images = DB::table('images')->get();
                                            $title = '';
                                            foreach ($images as $image){
                                              if($image->pet_id == $pet->id){
                                                $title = trim(str_replace("public/images/","", $image->path));
                                              }
                                            }
                                        @endphp
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        @foreach($images as $image)
                                            @if($image->pet_id == $pet->id)
                                                @php
                                                  $title = trim(str_replace("public/images/","", $image->path));
                                                @endphp
                                                <img src="{{ asset('storage/images/'.$title) }}" style="width: 50%; height: auto; border-radius: 2%; display: block; margin-left: auto; margin-right: auto;" >
                                            @endif
                                        @endforeach

                                        <input id="status" type="text" name="status" class="form-control" value="{{$pet->status === 'Pending' ? 'Picked up' : 'Confirmed'}}" hidden>

                                        <div class="form-group">
                                            <label id="picUpLabel" class="mb-1">Pick Up Date</label>
                                            <div class="input-group">
                                                <input id="pickUpDate" type="{{$pet->status === 'Pending' ? 'date' : 'text'}}" class="form-control" name="pickUpDate" placeholder="Enter pick up date" value="{{$pet->status === 'Pending' ? old('pickUpDate') : date('d-M-Y', strtotime($pet->pickUpDate))}}" {{$pet->status === 'Pending' ? '' : 'disabled'}}{{$pet->status === 'Pending' ? 'required' : ''}}>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-default float-right" href="{{route('pets.index')}}">{{ __('Cancel') }}</a>
                                            <button type="submit" class="btn btn-success">{{$pet->status === 'Pending' ? 'Pick Up' : 'Confirm'}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- Default box -->
            <!-- /.card -->
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection

