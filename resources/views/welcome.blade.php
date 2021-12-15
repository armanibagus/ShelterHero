{{--
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>

    --}}
{{--  Tab icon  --}}{{--

    <link rel="icon" href="{{asset('artefact/dist/img/shelter-hero-logo2-white.png')}}" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('artefact/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-collapse layout-top-nav layout-navbar-fixed">
<style>
    .navbar {
        background-color: #eadece !important;
    }
    /*.layout-top-nav .wrapper .main-header .brand-image {
        height: 63px;
    }*/
</style>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light">
        <div class="container">
            <a href="" class="navbar-brand">
                <img src="{{asset('artefact/dist/img/shelter-hero-logo2-white.png')}}" alt="ShelterHero Logo" class="brand-image img-circle">
                <span class="brand-text font-weight">{{config('app.name')}}</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    @auth()
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Right navbar links -->
            @if (Route::has('login'))
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a href="#shelterHero" class="nav-link navbar-nav-scroll">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item">Some action </a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>

                        <li class="dropdown-divider"></li>

                        <!-- Level two dropdown-->
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                </li>

                                <!-- Level three dropdown-->
                                <li class="dropdown-submenu">
                                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                    </ul>
                                </li>
                                <!-- End Level three -->

                                <li><a href="#" class="dropdown-item">level 2</a></li>
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
                @auth
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown user-menu">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset('artefact/dist/img/unknown.png')}}" class="user-image img-circle elevation-2" alt="User Image">
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <!-- User image -->
                                <li class="user-header bg-white">
                                    <img src="{{asset('artefact/dist/img/unknown.png')}}" class="img-circle elevation-2" alt="User Image">
                                    <p>
                                        {{ Auth::user()->name }} - @if(Auth::user()->role === 'user')
                                            {{ 'User' }}
                                        @elseif(Auth::user()->role === 'volunteer')
                                            {{ 'Volunteer' }}
                                        @elseif(Auth::user()->role === 'pet_shelter')
                                            {{ 'Pet Shelter' }}
                                        @else
                                            {{ 'Undefined' }}
                                        @endif
                                        <small>Member since {{ Auth::user()->created_at->format('d M Y') }}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <a href="#" class="btn btn-outline-info">Profile</a>
                                    <a class="btn btn-outline-danger float-right" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                                        Log Out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="text-black nav-link">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                    </li>
                @endauth
            </ul>
            @endif
        </div>
    </nav>
    <!-- /.navbar -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Log Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-inf" data-dismiss="modal">Cancel</button>
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">Log Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Sidebar Container -->
    @extends('sidebar')

    <!-- Content Wrapper. Contains page content -->
    <section id="shelterHero">
        <div class="content-wrapper">
            --}}
{{-- Section 1 --}}{{--

            <div class="content" style="background-color: #eadece !important;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div><!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title m-0">Featured</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Special title treatment</h6>

                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title m-0">Featured</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Special title treatment</h6>

                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
        </div>
    </section>

        --}}
{{-- Section 2 --}}{{--

        <section id="about">
            <div class="content" >
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>

                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>

                                    <p class="card-text">
                                        Some quick example text to build on the card title and make up the bulk of the card's
                                        content.
                                    </p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div><!-- /.card -->
                        </div>
                        <!-- /.col-md-6 -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title m-0">Featured</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Special title treatment</h6>

                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title m-0">Featured</h5>
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title">Special title treatment</h6>

                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </section>
        <!-- /.content -->

    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @extends('footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('artefact/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('artefact/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- App -->
<script src="{{asset('artefact/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>

    <!-- Favicons -->
    <link rel="icon" href="{{asset('artefact/dist/img/shelter-hero-logo2-white.png')}}" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('artefact/Regna/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('artefact/Regna/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('artefact/Regna/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('artefact/Regna/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('artefact/Regna/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('artefact/Regna/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('artefact/dist/css/adminlte.min.css')}}">
    <!-- Template Main CSS File -->
    <link href="{{asset('artefact/Regna/assets/css/style.css')}}" rel="stylesheet">
</head>
<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div id="logo">
            <a href="index.html"><img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="width: 50%; height: auto" alt=""></a>
            <!-- Uncomment below if you prefer to use a text logo -->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                @auth
                <li>
                    <a class="nav-link fas fa-bars scrollto text-left" data-widget="pushmenu" href="#" role="button">
                        <strong><i class="fas fa-bars "></i></strong>
                    </a>
                </li>
                @endauth
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#services">Services</a></li>
                <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li>
                <li><a class="nav-link scrollto" href="#team">Team</a></li>
                <li><a class="nav-link scrollto" href="#contact">Contact</a></li>

                    @if (Route::has('login'))
                        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                            @auth
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown user-menu">
                                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                            <img src="{{asset('artefact/dist/img/unknown.png')}}" class="user-image img-circle elevation-2" alt="User Image">
                                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <!-- User image -->
                                            <li class="user-header bg-white">
                                                <img src="{{asset('artefact/dist/img/unknown.png')}}" class="img-circle elevation-2" alt="User Image">
                                                <p>
                                                    {{ Auth::user()->name }} - @if(Auth::user()->role === 'user')
                                                        {{ 'User' }}
                                                    @elseif(Auth::user()->role === 'volunteer')
                                                        {{ 'Volunteer' }}
                                                    @elseif(Auth::user()->role === 'pet_shelter')
                                                        {{ 'Pet Shelter' }}
                                                    @else
                                                        {{ 'Undefined' }}
                                                    @endif
                                                    <small>Member since {{ Auth::user()->created_at->format('d M Y') }}</small>
                                                </p>
                                            </li>
                                            <!-- Menu Body -->
                                            <li class="user-body">
                                                <div class="row">
                                                    <div class="col-4 text-center">
                                                        <a href="#">Followers</a>
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <a href="#">Sales</a>
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <a href="#">Friends</a>
                                                    </div>
                                                </div>
                                                <!-- /.row -->
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
{{--                                                <a href="#" class="btn btn-outline-info">Profile</a>--}}
                                                <a class="btn btn-outline-danger float-right" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                                                    Log Out
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="text-black nav-link">Log in</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="text-black nav-link">Register</a>
                                </li>
                            @endauth
                        </ul>
                    @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
        <!-- Main Sidebar Container -->
        @extends('sidebar')
    </div>
</header><!-- End Header -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelLogout">Log Out</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to log out?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-inf" data-dismiss="modal">Cancel</button>
                <a href="{{ route('logout') }}" class="btn btn-outline-danger" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <h1 style="color: black">Welcome to <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}"></h1><br>
        <h2 style="color: black">“If you pick up a starving dog and make him prosperous he will not bite you.<br>
        This is the principal difference between a dog and man.”</h2>

        <h2 style="color: black"><strong>– Mark Twain.</strong></h2>
        <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
</section><!-- End Hero Section -->

<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about">
        <div class="container" data-aos="fade-up">
            <div class="row about-container">

                <div class="col-lg-6 content order-lg-1 order-2">
                    <h2 class="title"><strong>About Us</strong></h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>

                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon"><i class="bi bi-briefcase"></i></div>
                        <h4 class="title"><a href="">Eiusmod Tempor</a></h4>
                        <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
                    </div>

                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="bi bi-card-checklist"></i></div>
                        <h4 class="title"><a href="">Magni Dolores</a></h4>
                        <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    </div>

                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class="bi bi-binoculars"></i></div>
                        <h4 class="title"><a href="">Dolor Sitema</a></h4>
                        <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
                    </div>

                </div>

                <div class="col-lg-6 background order-lg-2 order-1" data-aos="fade-left" data-aos-delay="100"></div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Facts Section ======= -->
    <section id="facts">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Facts</h3>
                <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>
            <div class="row counters">

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Clients</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="534" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Projects</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Hours Of Support</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="42" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Hard Workers</p>
                </div>

            </div>

        </div>
    </section><!-- End Facts Section -->

    <!-- ======= Services Section ======= -->
    <section id="services">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Services</h3>
                <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="box">
                        <div class="icon"><a href=""><i class="bi bi-briefcase"></i></a></div>
                        <h4 class="title"><a href="">Lorem Ipsum</a></h4>
                        <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="box">
                        <div class="icon"><a href=""><i class="bi bi-card-checklist"></i></a></div>
                        <h4 class="title"><a href="">Dolor Sitema</a></h4>
                        <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="box">
                        <div class="icon"><a href=""><i class="bi bi-bar-chart"></i></a></div>
                        <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
                        <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="box">
                        <div class="icon"><a href=""><i class="bi bi-binoculars"></i></a></div>
                        <h4 class="title"><a href="">Magni Dolores</a></h4>
                        <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="box">
                        <div class="icon"><a href=""><i class="bi bi-brightness-high"></i></a></div>
                        <h4 class="title"><a href="">Nemo Enim</a></h4>
                        <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                    <div class="box">
                        <div class="icon"><a href=""><i class="bi bi-calendar4-week"></i></a></div>
                        <h4 class="title"><a href="">Eiusmod Tempor</a></h4>
                        <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Call To Action Section ======= -->
    <section id="call-to-action">
        <div class="container">
            <div class="row" data-aos="zoom-in">
                <div class="col-lg-9 text-center text-lg-start">
                    <h3 class="cta-title">Call To Action</h3>
                    <p class="cta-text"> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <div class="col-lg-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="#">Call To Action</a>
                </div>
            </div>

        </div>
    </section><!-- End Call To Action Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Portfolio</h3>
                <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-app">App</li>
                        <li data-filter=".filter-card">Card</li>
                        <li data-filter=".filter-web">Web</li>
                    </ul>
                </div>
            </div>

            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                    <img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>App 1</h4>
                        <p>App</p>
                        <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Web 3</h4>
                        <p>Web</p>
                        <a href="assets/img/portfolio/portfolio-2.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                    <img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>App 2</h4>
                        <p>App</p>
                        <a href="assets/img/portfolio/portfolio-3.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Card 2</h4>
                        <p>Card</p>
                        <a href="assets/img/portfolio/portfolio-4.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Web 2</h4>
                        <p>Web</p>
                        <a href="assets/img/portfolio/portfolio-5.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                    <img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>App 3</h4>
                        <p>App</p>
                        <a href="assets/img/portfolio/portfolio-6.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Card 1</h4>
                        <p>Card</p>
                        <a href="assets/img/portfolio/portfolio-7.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Card 3</h4>
                        <p>Card</p>
                        <a href="assets/img/portfolio/portfolio-8.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Web 3</h4>
                        <p>Web</p>
                        <a href="assets/img/portfolio/portfolio-9.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Portfolio Section -->

    <!-- ======= Team Section ======= -->
    <section id="team">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Team</h3>
                <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="100">
                        <div class="pic"><img src="assets/img/team-1.jpg" alt=""></div>
                        <h4>Walter White</h4>
                        <span>Chief Executive Officer</span>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="200">
                        <div class="pic"><img src="assets/img/team-2.jpg" alt=""></div>
                        <h4>Sarah Jhinson</h4>
                        <span>Product Manager</span>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="300">
                        <div class="pic"><img src="assets/img/team-3.jpg" alt=""></div>
                        <h4>William Anderson</h4>
                        <span>CTO</span>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="400">
                        <div class="pic"><img src="assets/img/team-4.jpg" alt=""></div>
                        <h4>Amanda Jepson</h4>
                        <span>Accountant</span>
                        <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Team Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact">
        <div class="container">
            <div class="section-header">
                <h3 class="section-title">Contact</h3>
                <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>
            </div>
        </div>

        <!-- Uncomment below if you wan to use dynamic maps -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22864.11283411948!2d-73.96468908098944!3d40.630720240038435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew+York%2C+NY%2C+USA!5e0!3m2!1sen!2sbg!4v1540447494452" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>

        <div class="container mt-5">
            <div class="row justify-content-center">

                <div class="col-lg-3 col-md-4">

                    <div class="info">
                        <div>
                            <i class="bi bi-geo-alt"></i>
                            <p>A108 Adam Street<br>New York, NY 535022</p>
                        </div>

                        <div>
                            <i class="bi bi-envelope"></i>
                            <p>info@example.com</p>
                        </div>

                        <div>
                            <i class="bi bi-phone"></i>
                            <p>+1 5589 55488 55s</p>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>

                </div>

                <div class="col-lg-5 col-md-8">
                    <div class="form">
                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group mt-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">

        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong>Regna</strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Regna
          -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{asset('artefact/Regna/assets/vendor/purecounter/purecounter.js')}}"></script>
<script src="{{asset('artefact/Regna/assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('artefact/Regna/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('artefact/Regna/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('artefact/Regna/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('artefact/Regna/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('artefact/Regna/assets/vendor/php-email-form/validate.js')}}"></script>
<!-- jQuery -->
<script src="{{asset('artefact/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('artefact/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- App -->
<script src="{{asset('artefact/dist/js/adminlte.min.js')}}"></script>
<!-- Template Main JS File -->
<script src="{{asset('artefact/Regna/assets/js/main.js')}}"></script>
</body>

</html>
