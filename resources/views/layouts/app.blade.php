<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ Request::is('login') ? 'Log in' : 'Register' }} | {{config('app.name')}}</title>

    {{--  Tab icon  --}}
    <link rel="icon" href="{{asset('artefact/dist/img/shelter-hero-logo2-white.png')}}" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('artefact/dist/css/adminlte.min.css')}}">

{{--<style>
    .card-primary.card-outline {
        border-top: 3px solid #eadece !important;
    }
</style>--}}
<body class="hold-transition {{ Request::is('login') ? 'login-page' : 'register-page' }}" style="background-color: #eadece !important">
<div class="{{ Request::is('login') ? 'login-box' : 'register-box' }}">

    <div class="card card-outline card-primary">
        <!-- logo -->
        <div class="card-header text-center">
            <a href="{{url('/')}}" class="h1"><img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" alt="Shelter Hero Logo"></a>
        </div>
        @yield('content')
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('artefact/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('artefact/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- App -->
<script src="{{asset('artefact/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
