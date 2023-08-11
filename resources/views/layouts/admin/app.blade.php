<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Gestion de parking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .select2-selection__choice{
            color:#34567a!important;
        }
        #loading {
            position: fixed;
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            text-align: center;
            opacity: 1;
            background-color: #fff;
            z-index: 99;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    <div id="loading">
        <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status"></div>
        </div>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">

                <div class="d-flex align-items-left">
                    <button type="button" class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center">


                    <div class="dropdown d-inline-block">

                        @if(app()->getLocale() == 'ar')
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="" src="{{ asset('assets/images/flags/morocco.png') }}" alt="Header Language" height="16">
                            <span class="d-none d-sm-inline-block ml-1">{{ __('العربية') }}</span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        @else
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="" src="{{ asset('assets/images/flags/french.jpg') }}" alt="Header Language" height="16">
                            <span class="d-none d-sm-inline-block ml-1">{{ __('Français') }}</span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        @endif

                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="{{ route('changelang', 'ar') }}" class="dropdown-item notify-item">
                                <img src="{{ asset('assets/images/flags/morocco.png') }}" alt="user-image" class="mr-1" style="width: 1.25rem; height: auto;" >
                                <span class="align-middle">{{ __('العربية') }}</span>
                            </a>

                            <a href="{{ route('changelang', 'fr') }}" class="dropdown-item notify-item">
                                <img src="{{ asset('assets/images/flags/french.jpg') }}" alt="user-image" class="mr-1" height="12">
                                <span class="align-middle">{{ __('Français') }}</span>
                            </a>

                        </div>
                        
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge badge-danger badge-pill">
                                {{ $numberOfNotification }}
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>

                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                @foreach ($chargeNotification as $notif)

                                <a href="{{ route('admin.vehicule.edit', $notif['vehicule_id']) }}" class="text-reset notification-item">
                                    <div class="media">

                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">{{ $notif['vehicule'] }}</h6>
                                            <p class="font-size-13 mb-1">{{ $notif['message'] }}</p>

                                        </div>
                                    </div>
                                </a>
                                @endforeach

                                @foreach ($stockNotification as $stock)
                                <a href="{{ route('admin.stock') }}" class="text-reset notification-item">
                                    <div class="media">

                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">{{ $stock->name }}</h6>
                                            <p class="font-size-13 mb-1">{{ $stock->message }}</p>

                                        </div>
                                    </div>
                                </a>
                                @endforeach

                                @foreach ($trips as $trip)
                                <a href="{{ route('admin.trip.edit', Crypt::encrypt($trip->id)) }}" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">{{ 'Trip :'. $trip->driver->full_name.' | '.$trip->vehicule->brand.'-'.$trip->vehicule->model }}</h6>
                                            <p class="font-size-13 mb-1">{{ __('Trip expired') }}</p>
                                        </div>
                                    </div>
                                </a>
                                @endforeach

                            </div>

                        </div>
                    </div>

                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                alt="Header Avatar">
                            <span class="d-none d-sm-inline-block ml-1">{{ auth()->user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('profile.edit') }}">
                                <span>{{ __('Profile') }}</span>

                            </a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf

                                <button type="submit" class="dropdown-item d-flex align-items-center justify-content-between">{{ __('deconnexion') }}</button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <div class="navbar-brand-box">
                    <a href="index.html" class="logo">
                        Fidiacom
                    </a>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">{{ __('Menu') }}</li>

                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect">
                                <i class='bx bx-home-smile'></i>
                                <span>{{ __('Tableau de bord') }}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.vehicule') }}" class="wwaves-effect"><i
                                    class="bx bx-car"></i>
                                    <span>{{ __('Vehicule') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.drivers') }}" class="wwaves-effect"><i
                                    class="bx bx-user"></i>
                                    <span>{{ __('Conducteur') }}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.trip') }}" class="wwaves-effect"><i
                                    class="mdi mdi-road"></i>
                                    <span>{{ __('Ordre de mission') }}</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect"><i class="mdi mdi-package"></i></i><span>{{ __('Stock') }}</span></a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ route('admin.stock-entry') }}">{{ __('Entree de stock') }}</a></li>
                                <li><a href="{{ route('admin.stock') }}">{{ __('Gestion du stock') }}</a></li>
                                <li><a href="{{ route('admin.stockHistorie') }}">{{ __('Historique Stock') }}</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                {{ $slot }}
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            © Fidiacom.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Design & Develop by Fidiacom
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Overlay-->
    <div class="menu-overlay"></div>


    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>

     <!-- third party js -->
     <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.flash.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/dataTables.select.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
     <!-- third party js ends -->



     <script src="{{ asset('assets/plugins/autonumeric/autoNumeric-min.js') }}"></script>
     <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
     <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
     <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
     <script src="{{ asset('assets/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

     <!-- Custom Js -->

     <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

     <script src="{{ asset('assets/pages/advanced-plugins-demo.js') }}"></script>

    <!-- Datatables init -->
    <script src="{{ asset('assets/pages/datatables-demo.js') }}"></script>

    <!-- Morris Js-->
    <script src="{{ asset('assets/plugins/morris-js/morris.min.js') }}"></script>
    <!-- Raphael Js-->
    <script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>

    <!-- Morris Custom Js-->
    <script src="{{ asset('assets/pages/dashboard-demo.j') }}s"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>



    <!--dropify-->
    <script src="{{ asset('assets/plugins/dropify/dropify.min.js') }}"></script>

    <!-- Init js-->
    <script src="{{ asset('assets/pages/fileuploads-demo.js') }}"></script>

<script>
    window.addEventListener('load',() => {
        document.getElementById("loading").style.display = "none";
    });
</script>

</body>

</html>
