<style>
    .main-sidebar {
        background-color: #eadece !important;
        min-height: 100%;
    }
    .text-light {
        color: #869099 !important;
    }
    .form-control-sidebar:hover {
        background-color: #fff !important;
        border: 1px solid #6c757d;
    }
    .form-control-sidebar {
        background-color: #eadece !important;
        border: 1px solid #6c757d;
    }
    .btn-sidebar {
        background-color: #eadece !important;
        border: 1px solid #6c757d;
        color: #56606a;
    }
    .btn-sidebar:hover {
        background-color: #f1e9df !important;
        border: 1px solid #56606a;
        color: #56606a;
    }
    .nav-item-sidebar:hover {
        background-color: #f1e9df;
        border-radius: 0.25rem;
    }
</style>
@auth()
<aside class="main-sidebar elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('artefact/dist/img/shelter-hero-logo2-white.png')}}" alt="ShelterHero Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text text-gray-dark font-weight">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" style="border: 1px solid #56606a;" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('/')}}" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Go to Home</p>
                    </a>
                </li>
                <li class="nav-header">Menu</li>
                <li class="nav-item">
                    <a href="@if(Auth::user()->role === 'user')
                                {{url('/user/home')}}
                             @elseif(Auth::user()->role === 'volunteer')
                                {{url('/volunteer/home')}}
                             @elseif(Auth::user()->role === 'pet_shelter')
                                {{url('/pet-shelter/home')}}
                             @else
                                {{ url('/home') }}
                             @endif"
                       class="nav-link {{ Request::is('home') || Request::is('user/home') || Request::is('volunteer/home') || Request::is('pet-shelter/home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Main Menu</p>
                    </a>
                </li>
                @if(Auth::user()->role === 'user')
                    <li class="nav-header">Requests</li>
                    <li class="nav-item">
                        <a href="{{route('pets.create')}}" class="nav-link {{Request::is('pets/create') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-dog"></i>
                            <p>Register Pet</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-heart"></i>
                            <p>Pet Adoption</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Lost Pet Claim</p>
                        </a>
                    </li>
                    <li class="nav-header">Donation</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-donate"></i>
                            <p>Donate</p>
                        </a>
                    </li>
                    <li class="nav-header">Views</li>
                    <li class="nav-item {{Request::is('pets') ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-paw"></i>
                            <p>
                                Pet & Shelter
                                <i class="right fas fa-caret-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('pets.index')}}" class="nav-link {{Request::is('pets') ? 'active' : ''}}">
                                    <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                    <p>Lost Pets</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                    <p>All Pets</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                    <p>Pet Shelters</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Activity History</p>
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'volunteer')
                    <li class="nav-header">Request</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-heartbeat"></i>
                            <p>Pet Medical Checkup</p>
                        </a>
                    </li>
                    <li class="nav-header">Views</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-paw"></i>
                            <p>
                                Pet & Shelter
                                <i class="right fas fa-caret-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                    <p>All Pets</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-arrow-alt-circle-right nav-icon"></i>
                                    <p>Pet Shelters</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Pet Medical History</p>
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'pet_shelter')
                    <li class="nav-header">Requests</li>
                    <li class="nav-item">
                        <a href="{{route('pets.index')}}" class="nav-link {{Request::is('pets')||Request::is('pets/*/edit') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Pet Registration</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Adoption Request</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Lost Pet Claim</p>
                        </a>
                    </li>
                    <li class="nav-header">Donation</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Open Donation</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Donation History</p>
                        </a>
                    </li>
                    <li class="nav-header">Volunteer</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Request Volunteer</p>
                        </a>
                    </li>
                    <li class="nav-header">Views</li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-paw nav-icon"></i>
                            <p>All Pets</p>
                        </a>
                    </li>
                @else
                    {{ '/home' }}
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@endauth
