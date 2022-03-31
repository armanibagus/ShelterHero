@extends('template')

@section('page-title')
    {{__('Donate Details')}}
@endsection

@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Donate Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'user')
                            <li class="breadcrumb-item active">Donate Details</li>
                        @endif
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
          if($image->donate_id == $donate->id){
            $title = trim(str_replace("public/donation-img/","", $image->path));
            break;
          }
        }
    @endphp
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-8" style="margin: auto">
                <div class="card card-success card-outline">
                    <div class="card-body">
                        <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="display: block; margin: auto; width: 30%" alt="logo image">
                        <br>
                        <div class="card-header">
                            <h2 class="card-title text-bold text-lg text-center" style="float: none">Donate Details</h2>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <dl>
                                        <dt style="font-weight: 400">{{ __('Full Name') }}</dt>
                                        <dd><strong>{{ __($donate->name) }}</strong></dd>
                                        <dt style="font-weight: 400">{{ __('Email Address') }}</dt>
                                        <dd><strong>{{ __($donate->email) }}</strong></dd>
                                        <dt style="font-weight: 400">{{ __('Phone Number') }}</dt>
                                        <dd><strong>{{ __($donate->phone) }}</strong></dd>
                                        <dt style="font-weight: 400">{{ __('Payment Method') }}</dt>
                                        <dd><strong><i class="far fa-credit-card"></i> {{ __($donate->payment_method) }}</strong></dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl>
                                        <dt style="font-weight: 400">{{ __('Donate Amount') }}</dt>
                                        <dd><strong>@currency($donate->donate_amount)</strong></dd>
                                        <dt style="font-weight: 400">{{ __('Comment') }}</dt>
                                        <dd><strong>{{ __($donate->comment) }}</strong></dd>
                                        <dt style="font-weight: 400">{{ __('Status') }}</dt>
                                        @if($donate->status == 'Pending')
                                            <dd class="text-warning"><strong><i class="fas fa-exclamation-triangle "></i> {{ __($donate->status) }}</strong></dd>
                                        @elseif($donate->status == 'Accepted')
                                            <dd class="text-success"><strong><i class="fas fa-check-circle"></i> {{ __($donate->status) }}</strong></dd>
                                        @elseif($donate->status == 'Rejected')
                                            <dd class="text-danger"><strong><i class="fas fa-times"></i> {{ __($donate->status) }}</strong></dd>
                                        @endif
                                        <dt style="font-weight: 400">{{ __('Feedback') }}</dt>
                                        @if($donate->feedback == null)
                                            <dd><strong>{{ __('-') }}</strong></dd>
                                        @else
                                            <dd><strong>{{ __($donate->feedback) }}</strong></dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>
                            <dl>
                                <br>
                                <dt>{{ __('Receipt') }}</dt>
                            </dl>
                            <img class="img-fluid" src="{{ asset('storage/donation-img/'.$title) }}" alt="Donation main picture" style="object-fit: cover">
                            @if($donate->status == 'Pending' && Auth::user()->role == 'pet_shelter')
                            <form method="POST" action="{{route('donates.update', $donate->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="mt-3">Status</label>
                                    <select id="status" type="text" name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option selected disabled value="" >---[Select one]---</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="Accepted">Accepted</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label id="feedbackLabel" class="mb-1">Feedback</label>
                                    <div class="input-group">
                                        <textarea id="feedback" type="text" class="form-control @error('feedback') is-invalid @enderror" name="feedback" placeholder="Type here..." required rows="4">{{ old('feedback') }}</textarea>

                                        @error('feedback')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-block float-right mt-2">
                                    {{ __('Submit') }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
