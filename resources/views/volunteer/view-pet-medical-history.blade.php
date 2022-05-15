@extends('template')

@section('page-title')
    {{__('Pet Medical History')}}
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{__('Pet Medical History')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/volunteer/home')}}">Main Menu</a></li>
                            <li class="breadcrumb-item active">{{__('Pet Medical History')}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                @foreach($medical_reports as $report)
                    <div class="col-lg-3">
                        <a class="btn" style="padding: 0" href="{{route('health-checks.show', $report->id)}}">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user">
                                @php
                                    $image = DB::table('images')->where('id', '=', $report->pet_id)->first();
                                    $title = trim(str_replace("public/images/","", $image->path));
                                @endphp
                                <div style="text-align: center">
                                    <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                                </div>
                                <div class="card-body text-center">
                                    <strong class="text-lg">{{$report->nickname}}</strong>
                                    @if($report->sex === 'Male')
                                        <i class="nav-icon text-blue fas fa-mars"></i>
                                    @elseif($report->sex === 'Female')
                                        <i class="nav-icon text-pink fas fa-venus"></i>
                                    @endif
                                    <br>
                                    {{ __($report->size) }} • {{ __($report->petType) }}<br>
                                    <div class="text-muted text-sm">
                                        {{$report->name}}<br>
                                    </div>
                                </div>
                                <div class="card-footer text-sm text-right text-muted" style="padding-top: 15px">
                                    {{ date('d M Y', strtotime($report->created_at)) }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
