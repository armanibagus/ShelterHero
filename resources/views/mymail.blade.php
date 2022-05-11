@component('mail::message')
{{ $message['title'] }}
@php
  $pet = $message['pet'];
  $shelter = $message['pet_shelter'];
  $req_title = ''; $req_subtitle = ''; $status = '';
  if ($message['data'] instanceof \App\Models\LostPetClaim) {
    $req_title = 'lost pet claim';
  } else if ($message['data'] instanceof \App\Models\Adoption) {
    $req_title = 'adoption';
  }

  $message['data']->status === 'Accepted' ? $status = 'Congratulation! Y' : $status = 'Sorry, y';
@endphp


 {{$status}}our {{$req_title}} request has been <strong>{{$message['data']->status}}</strong> by {{$shelter->name}}.<br>
    <span style="margin-left: 40px">Request ID: <strong>{{$message['data']->id}}</strong></span><br>
    <span style="margin-left: 40px">Request Date: <strong>{{ \Carbon\Carbon::parse($message['data']->created_at)->isoFormat('DD MMMM YYYY') }}</strong></span><br>
    <span style="margin-left: 40px">Pet ID: <strong>{{$pet->id}}</strong></span><br>
    <span style="margin-left: 40px">Pet Nickname: <strong>{{$pet->nickname}}</strong></span><br>
@if($message['data']->status === 'Accepted')
    <span style="margin-left: 40px">Date Delivered: <strong>{{ \Carbon\Carbon::parse($message['data']->delivery_date)->isoFormat('DD MMMM YYYY')}}</strong></span><br>
@endif

{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}
Thank you for using our application!

Regards,<br>
{{ config('app.name') }}
@endcomponent
