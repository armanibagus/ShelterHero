<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if(Request::is('home') || Request::is('user/home') || Request::is('volunteer/home') || Request::is('pet-shelter/home'))
            {{__('Home')}}
        @else
            @yield('page-title')
        @endif | {{config('app.name')}}
    </title>

    {{--  Tab icon  --}}
    <link rel="icon" href="{{asset('artefact/dist/img/shelter-hero-logo2-white.png')}}" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('artefact/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('artefact/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('artefact/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('artefact/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
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
    @yield('content-wrapper')

    <!-- Main Footer -->
    @extends('footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('artefact/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('artefact/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('artefact/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('artefact/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('artefact/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('artefact/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('artefact/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('artefact/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- App -->
<script src="{{asset('artefact/dist/js/adminlte.min.js')}}"></script>
<script>
    $(function() {
// Multiple images preview with JavaScript
        var previewImages = function(input, imgPreviewPlaceholder) {
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $($.parseHTML('<img style="width: 100%; height: auto">')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        $('#images').on('change', function() {
            previewImages(this, 'div.images-preview-div');
        });

        $("#dataTable1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })/*.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)')*/;
        $('#dataTable2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $("#dataTable3").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#dataTable3_wrapper .col-md-6:eq(0)');
        $("#dataTable4").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#dataTable4_wrapper .col-md-6:eq(0)');
        $("#dataTable5").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        })/*.buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)')*/;
    });
</script>
</body>
</html>
