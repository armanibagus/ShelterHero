@component('mail::message')
{{ $message['title'] }}

@php
  $message['request']->status === 'Accepted' ? $status = 'Congratulation! Y' : $status = 'Sorry, y';
@endphp

{{ $status }}our volunteer request has been <strong>{{ $message['request']->status }}</strong> by {{ $message['volunteer']->name}}.<br>
<span style="margin-left: 40px">Request ID: <strong>{{$message['request']->id}}</strong></span><br>
<span style="margin-left: 40px">Proposed Checkup Date: <strong>{{ \Carbon\Carbon::parse($message['request']->checkup_date)->isoFormat('DD MMMM YYYY')}}</strong></span><br>
<span style="margin-left: 40px">Shelter Name: <strong>{{ $message['pet_shelter']->name }}</strong></span><br>
<span style="margin-left: 40px">License: <strong>{{ $message['pet_shelter']->identityNumber }}</strong></span><br>
<span style="margin-left: 40px">Pet ID: <strong>{{ $message['pet']->id }}</strong></span><br>
<span style="margin-left: 40px">Pet Nickname: <strong>{{ $message['pet']->nickname }}</strong></span><br>


{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent--}}

Thank you for using our application!

Regards,<br>
{{ config('app.name') }}
@endcomponent
