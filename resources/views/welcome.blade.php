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
@php
    // pets
    $total_pets = \App\Models\Pet::where([['status', '=', 'Confirmed'], ['pickUpDate', '!=', NULL]])->count();

    // donations
    $total_donations = \App\Models\Donate::count();

    // donation request
    $all_donation_request = \App\Models\Donation::where('expiry_date', '>', \Carbon\Carbon::now())->latest()->get();

    // lost pet claims
    $new_pets = \App\Models\Pet::join('users', 'users.id', 'pets.shelter_id')
                ->where([['pets.status', '=', 'Confirmed'],
                         ['pets.pickUpDate', '>', \Carbon\Carbon::now()->subDays(7)]])
                ->select(['pets.*', 'users.name', 'users.address'])->latest()->get();
    $claims = DB::table('lost_pet_claims')->get();
    $lost_pets = \App\Http\Controllers\PetController::validatePets($new_pets, $claims);

    // pet adoption
    $old_pet = \App\Models\Pet::join('users', 'users.id', 'pets.shelter_id')
                ->where([['pets.status', '=', 'Confirmed'],
                         ['pets.pickUpDate', '<', \Carbon\Carbon::now()->subDays(7)]])
                ->select(['pets.*', 'users.name', 'users.address'])->latest()->get();
    $adoption = DB::table('adoptions')->get();
    $adopt_pets = \App\Http\Controllers\PetController::validatePets($old_pet, $adoption);
@endphp
<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center wrapper">
        <div id="logo">
            <a href="{{url('/')}}"><img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" style="width: 50%; height: auto" alt=""></a>
            <!-- Uncomment below if you prefer to use a text logo -->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#about">About</a></li>
                <li><a class="nav-link scrollto" href="#adopt-pet">Adoption</a></li>
                <li><a class="nav-link scrollto" href="#lost-pet">Lost Pet</a></li>
                <li><a class="nav-link scrollto" href="#donate">Donate</a></li>
                @auth
                    @php
                        if(Auth::user()->role == 'user')
                            $url = '/user/home';
                        else if(Auth::user()->role == 'volunteer')
                          $url = '/volunteer/home';
                        else if(Auth::user()->role == 'pet_shelter')
                          $url = '/pet-shelter/home';
                    @endphp
                    <li><a class="" href="{{url($url)}}"><strong>Main Menu<i class="fas fa-arrow-right"></i></strong></a></li>
                @endauth

                @if (Route::has('login'))
                    @auth
                        <li class="nav-item dropdown user-menu">
                            <a href="#" class="" data-toggle="dropdown" style="display: block">
                                @if(Auth::user()->photo_title != NULL && Auth::user()->photo_path != NULL)
                                    @php
                                        $title = trim(str_replace("public/profile-picture/","", Auth::user()->photo_path));
                                    @endphp
                                    <img class="img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 2.1rem; width: 2.1rem; object-fit: cover;">
                                @else
                                    <img src="{{ asset('artefact/dist/img/unknown.png') }}" class="icon" style="height: 2.1rem; width: 2.1rem;" alt="User Image">
                                @endif
                                <span><strong>{{ Auth::user()->name }}</strong></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <!-- User image -->
                                <li class="user-header bg-white" style="text-align: center; height: 175px; padding: 10px">
                                    @if(Auth::user()->photo_title != NULL && Auth::user()->photo_path != NULL)
                                        @php
                                            $title = trim(str_replace("public/profile-picture/","", Auth::user()->photo_path));
                                        @endphp
                                        <img class="img-circle" src="{{ asset('storage/profile-picture/'.$title) }}" alt="User profile picture" style="height: 90px; width: 90px;object-fit: cover;">
                                    @else
                                        <img src="{{ asset('artefact/dist/img/unknown.png') }}" style="height: 90px; width: 90px;" alt="User Image">
                                    @endif
                                    <p style="text-align: center; font-size: 17px; margin: 10px 0 0">
                                        {{ Auth::user()->name }} - @if(Auth::user()->role === 'user')
                                            {{ 'User' }}
                                        @elseif(Auth::user()->role === 'volunteer')
                                            {{ 'Volunteer' }}
                                        @elseif(Auth::user()->role === 'pet_shelter')
                                            {{ 'Pet Shelter' }}
                                        @else
                                            {{ 'Undefined' }}
                                        @endif
                                        <br>
                                        <small style="font-size: 12px">Member since {{ Auth::user()->created_at->format('d M Y') }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li style="padding: 10px; background-color: #f8f9fa">
                                    <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-primary float-left" style="color: #fff">Profile</a>
                                    <a class="btn btn-danger float-right" style="color: #fff" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                                        Log Out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="text-black nav-link">Log in</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="text-black nav-link">Register</a>
                        </li>
                    @endauth
                @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
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
        <h1 style="color: black">Welcome to <img src="{{asset('artefact/dist/img/shelter-hero-logo.png')}}" alt="shelter-hero-logo"></h1><br>
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
                        ShelterHero is a web-based application where users are able to help
                        disadvantaged animals to find a safe home, get a medical support
                        as well as helping people to find their lost pet.
                    </p>
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon"><i class='nav-icon fas fa-paw'></i></div>
                        <h4 class="title"><a href="#adopt-pet">Pet Adoption</a></h4>
                        <p class="description">
                            Find out a bunch of pet that is available
                            for adoption in any pet shelter that is registered in ShelterHero website.
                        </p>
                    </div>
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="fas fa-check"></i></div>
                        <h4 class="title"><a href="#lost-pet">Lost Pet Claim</a></h4>
                        <p class="description">
                            Make a claim of your lost pet in the ShelterHero website
                            that is being registered and fostered by our pet shelter.
                        </p>
                    </div>
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class='bx bx-donate-heart'></i></div>
                        <h4 class="title"><a href="#donate">Donation</a></h4>
                        <p class="description">
                            Send donation to help pet shelters to feed and give medical treatment to their pets.
                        </p>
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
                <h3 class="section-title">Fact</h3>
                <p class="section-description">
                    Join with us! Save many pets and help them find their home together
                </p>
            </div>
            <div class="row counters">

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="{{$total_pets}}" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Pets</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="{{$claims->count()}}" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Adoptions</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="{{$adoption->count()}}" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Lost Pet Claims</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="{{$total_donations}}" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Donations</p>
                </div>

            </div>

        </div>
    </section><!-- End Facts Section -->

    <!-- ======= Services Section ======= -->
    <section id="adopt-pet">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Adopt a Pet</h3>
                <p class="section-description">
                    Find your pet bestfriend now!
                    Our pets are animals that were rescued from disadvantaged situation.
                    You can now help them by adopting and giving them a new home and family!
                </p>
            </div>
            <div class="row justify-content-center">
                @if(count($adopt_pets) > 0)
                    @php
                        $count_adopt = 0;
                        foreach($adopt_pets as $pet) {
                          if ($count_adopt < 3)
                            $count_adopt++;
                          else
                            break;
                    @endphp
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                        <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                        @php
                            $pet_img = \App\Models\Image::where('pet_id', '=', $pet->id)->first();
                            $title = '';
                            if ($pet_img != NULL)
                              $title = trim(str_replace("public/images/","", $pet_img->path));
                        @endphp
                        <div style="text-align: center; margin-bottom: -5px">
                            <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                        </div>
                        <div class="box">
                            <div class="icon"><i class="fas fa-paw"></i></div>
                            <h4 class="title">
                                {{ __($pet->nickname) }}
                                @if($pet->sex === 'Male')
                                    <i class="nav-icon text-blue fas fa-mars"></i>
                                @elseif($pet->sex === 'Female')
                                    <i class="nav-icon text-pink fas fa-venus"></i>
                                @endif
                            </h4>
                            <p class="text-muted">{{ __($pet->size) }} • {{ __($pet->petType) }}</p>
                            {{ __($pet->name) }} <br>
                            <small class="text-muted">{{$pet->address}}</small>
                        </div>
                        </a>
                    </div>
                    @php } @endphp
                @else
                    <p class="text-center m-0 p-3">{{ __('No pet available') }}</p>
                @endif
            </div>
        </div>
    </section>

    <section id="lost-pet" class="lost-pet">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Claim a Lost Pet</h3>
                <p class="section-description">
                    Now you can search for your lost pet through the internet!
                    Using ShelterHero, you will be able to look for pets
                    that are registered as a lost pet by our pet shelters!
                </p>
            </div>
            <div class="row justify-content-center">
                @if(count($lost_pets) > 0)
                    @php
                        $count_lost = 0;
                        foreach($lost_pets as $pet) {
                          if ($count_lost < 3)
                            $count_lost++;
                          else
                            break;
                    @endphp
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                        <a class="btn" style="padding: 0" href="{{route('pets.show', $pet->id)}}">
                            @php
                                $pet_img = \App\Models\Image::where('pet_id', '=', $pet->id)->first();
                                $title = '';
                                if ($pet_img != NULL)
                                  $title = trim(str_replace("public/images/","", $pet_img->path));
                            @endphp
                            <div style="text-align: center; margin-bottom: -5px">
                                <img src="{{ asset('storage/images/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                            </div>
                            <div class="box">
                                <div class="icon"><i class="fas fa-check"></i></div>
                                <h4 class="title">
                                    {{ __($pet->nickname) }}
                                    @if($pet->sex === 'Male')
                                        <i class="nav-icon text-blue fas fa-mars"></i>
                                    @elseif($pet->sex === 'Female')
                                        <i class="nav-icon text-pink fas fa-venus"></i>
                                    @endif
                                </h4>
                                <p class="text-muted">{{ __($pet->size) }} • {{ __($pet->petType) }}</p>
                                {{ __($pet->name) }} <br>
                                <small class="text-muted">{{$pet->address}}</small>
                            </div>
                        </a>
                    </div>
                    @php } @endphp
                @else
                    <p class="text-center m-0 p-3">{{ __('No pet available') }}</p>
                @endif
            </div>
        </div>
    </section><!-- End lost-pet Section -->

    <!-- ======= Team Section ======= -->
    <section id="donate">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Send a Donation</h3>
                <p class="section-description">
                    Help our pet shelter by sending donation!
                    The donation will be used for the needs of our pet such as feeding,
                    medical support, and many more! Help them now!
                </p>
            </div>
            <div class="row justify-content-center">
                @if(count($all_donation_request) > 0)
                    @php
                        $count_donate = 0;
                        foreach($all_donation_request as $donation) {
                          if ($count_donate < 3)
                            $count_donate++;
                          else
                            break;
                    @endphp
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                        <a class="btn " style="padding: 0" href="{{route('donations.show', $donation->id)}}">
                            @php
                                $images = DB::table('donation_imgs')->latest()->get();
                                $title = '';
                                foreach ($images as $image) {
                                  if($image->donation_id == $donation->id){
                                    $title = trim(str_replace("public/donation-img/","", $image->path));
                                    break;
                                  }
                                }

                                // get the progress percentage
                                $progress = $donation->amount_get / $donation->amount_need * 100;
                            @endphp
                            <div style="text-align: center">
                                <img src="{{ asset('storage/donation-img/'.$title) }}" class="img-fluid" alt="Responsive image" style="border-radius: 2%; object-fit: cover; height: 280px; width: 500px">
                            </div>
                            <div class="card-body text-left">
                                <strong class="text-lg">{{ __($donation->title) }}</strong><br>
                                {{ __($donation->name) }}<br>
                                <div class="progress progress-xs mt-3">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$progress}}%" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="text-sm text-right mb-0">Total donation <strong>@currency($donation->amount_get)</strong></p>
                            </div>
                            <div class="card-footer text-sm text-right text-muted" style="padding-top: 15px">
                                {{ __(\Carbon\Carbon::createFromDate($donation->expiry_date)->diffForHumans()) }}
                            </div>
                        </a>
                    </div>
                    @php } @endphp
                @else
                    <p class="text-center m-0 p-3">{{ __('No donation request Available') }}</p>
                @endif
            </div>
        </div>
    </section><!-- End Team Section -->
    <section id="call-to-action">
        <div class="container">
            <div class="row" data-aos="zoom-in">
                <div class="col-lg-9 text-center text-lg-start">
                    <h3 class="cta-title">Join Us!</h3>
                    <p class="cta-text">
                        Gain relation with us and help thousands of pets find their home.
                        Register to ShelterHero website and find out the latest information about
                        pet adoption, lost pet claim, donation, and many more.
                    </p>
                </div>
                <div class="col-lg-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="{{ route('register') }}">Register Now!</a>
                </div>
            </div>

        </div>
    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="container">
        <div class="copyright">
            &copy; 2021 - <?php echo date('Y'); ?>, <a class="text-white" href="{{asset('')}}" style="color: #869099">{{config('app.name')}}.</a>
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
