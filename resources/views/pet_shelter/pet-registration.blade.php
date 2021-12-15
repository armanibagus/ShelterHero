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
                                <a href="{{url('/pet-shelter/home')}}">Main Menu</a>
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
                <div class="col-md-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist" >

                                {{-- Pending Tab Label --}}
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#view-pending-petregistration" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="true">Pending</a>
                                </li>

                                {{-- Pick Up Tab Label --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#pet-pick-up-history" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Pick Up</a>
                                </li>

                                {{-- Confirmed Tab Label --}}
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-five-normal-tab" data-toggle="pill" href="#pet-confirmed-history" role="tab" aria-controls="custom-tabs-five-normal" aria-selected="false">Confirmed</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-five-tabContent">
                                {{-- View registered pet tab --}}
                                <div class="tab-pane fade show active" id="view-pending-petregistration" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body table-responsive p-0">
                                        <table id="dataTable1" class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Pet ID</th>
                                                <th>Nickname</th>
                                                <th class="text-center">Type</th>
                                                <th>Registered By</th>
                                                <th class="text-center">Appointment Date</th>
                                                <th>Address</th>
                                                <th></th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pets as $pet)
                                                @php
                                                    $date = new \Carbon\Carbon($pet->created_at);
                                                    $expiredate = $date->addDays(3);
                                                @endphp
                                                @if($pet->status === 'Pending' && $expiredate > \Carbon\Carbon::today())
                                            <tr>
                                                <td class="text-center">{{$pet->id}}</td>
                                                <td>{{$pet->nickname}}</td>
                                                <td class="text-center">{{$pet->petType}}</td>
                                                <td>{{$pet->name}}</td> {{-- user name --}}
                                                <td class="text-center">{{date('d-M-Y', strtotime($pet->created_at))}}</td>
                                                <td>{{$pet->address}}</td>
                                                <td>
                                                    <div>
                                                        <a class="btn btn-outline-success float-right" href="{{route('pets.edit', $pet->id)}}">{{ __('Foster') }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                                {{-- Pick Up Tab --}}
                                <div class="tab-pane fade" id="pet-pick-up-history" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body table-responsive p-0">
                                        <table id="dataTable3" id="example3" class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Pet ID</th>
                                                <th>Nickname</th>
                                                <th class="text-center">Type</th>
                                                <th>Registered By</th>
                                                <th class="text-center">Pick Up Date</th>
                                                <th>Address</th>
                                                <th></th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pets as $pet)
                                                @php
                                                    $date = new \Carbon\Carbon($pet->created_at);
                                                    $expiredate = $date->addDays(3);
                                                @endphp
                                                @if($pet->status === 'Picked Up' && $pet->shelter_id === Auth::user()->id && $expiredate > \Carbon\Carbon::today())
                                                <tr>
                                                    <td class="text-center">{{$pet->id}}</td>
                                                    <td>{{$pet->nickname}}</td>
                                                    <td class="text-center">{{$pet->petType}}</td>
                                                    <td>{{$pet->name}}</td> {{-- user name --}}
                                                    <td class="text-center">{{date('d-M-Y', strtotime($pet->pickUpDate))}}</td>
                                                    <td>{{$pet->address}}</td>
                                                    <td>
                                                        <div>
                                                            <a class="btn btn-outline-success float-right" href="{{route('pets.edit', $pet->id)}}">{{ __('Confirm') }}</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Confirmed Tab --}}
                                <div class="tab-pane fade" id="pet-confirmed-history" role="tabpanel" aria-labelledby="custom-tabs-five-normal-tab">
                                    <div class="card-body table-responsive p-0">
                                        <table id="dataTable4" class="table table-hover text-nowrap">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Pet ID</th>
                                                <th>Nickname</th>
                                                <th class="text-center">Type</th>
                                                <th>Registered By</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Appointment Date</th>
                                                <th class="text-center">Pick Up Date</th>
                                                <th>Address</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($pets as $pet)
                                                @if($pet->status === 'Confirmed' && $pet->shelter_id === Auth::user()->id)
                                                    <tr>
                                                        <td class="text-center">{{$pet->id}}</td>
                                                        <td>{{$pet->nickname}}</td>
                                                        <td class="text-center">{{$pet->petType}}</td>
                                                        <td>{{$pet->name}}</td> {{-- user name --}}
                                                        <td class="text-center">{{$pet->status}}</td>
                                                        <td class="text-center">{{date('d-M-Y', strtotime($pet->created_at))}}</td>
                                                        <td class="text-center">{{date('d-M-Y', strtotime($pet->pickUpDate))}}</td>
                                                        <td>{{$pet->address}}</td>
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
            </div>
            <!-- Default box -->
            <!-- /.card -->
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
