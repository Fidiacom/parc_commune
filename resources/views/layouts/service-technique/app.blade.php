<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>{{ $communeName ?: 'Parc Management' }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="{{ $communeName ?: 'Parc Management' }} - {{ __('Service Technique Management System') }}" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- App css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            :root {
                --main-color: {{ $mainColor }};
                @if($secondColor)
                --second-color: {{ $secondColor }};
                @endif
            }

            .logo img {
                width: 6rem !important;
                margin: 2rem !important;
                height: auto !important;
            }

            /* Primary Color Styles */
            .btn-primary,
            .btn-primary:focus {
                background-color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
            }

            .btn-primary:hover,
            .btn-primary:active,
            .btn-primary.active {
                background-color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
                opacity: 0.9;
            }

            .btn-outline-primary {
                color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
            }

            .btn-outline-primary:hover,
            .btn-outline-primary:active,
            .btn-outline-primary.active {
                background-color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
                color: #fff !important;
            }

            .text-primary {
                color: {{ $mainColor }} !important;
            }

            .bg-primary {
                background-color: {{ $mainColor }} !important;
            }

            .border-primary {
                border-color: {{ $mainColor }} !important;
            }

            .badge-primary {
                background-color: {{ $mainColor }} !important;
                color: #fff !important;
            }

            .page-item.active .page-link {
                background-color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
            }

            .pagination .page-link:hover {
                color: {{ $mainColor }} !important;
            }

            a {
                color: {{ $mainColor }};
            }

            a:hover {
                color: {{ $mainColor }};
                opacity: 0.8;
            }

            .progress-bar {
                background-color: {{ $mainColor }} !important;
            }

            .nav-pills .nav-link.active,
            .nav-pills .show > .nav-link {
                background-color: {{ $mainColor }} !important;
            }

            .nav-tabs .nav-link.active {
                color: {{ $mainColor }} !important;
                border-bottom-color: {{ $mainColor }} !important;
            }

            .nav-tabs .nav-link:hover {
                border-color: {{ $mainColor }} !important;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: {{ $mainColor }} !important;
                box-shadow: 0 0 0 0.2rem rgba({{ $mainColorRgb }}, 0.25) !important;
            }

            .custom-control-input:checked ~ .custom-control-label::before {
                background-color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
            }

            .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
                background-color: {{ $mainColor }} !important;
            }

            .dropdown-item.active,
            .dropdown-item:active {
                background-color: {{ $mainColor }} !important;
            }

            .list-group-item.active {
                background-color: {{ $mainColor }} !important;
                border-color: {{ $mainColor }} !important;
            }

            /* Sidebar Active Menu Item */
            .metismenu .mm-active > a,
            .metismenu a:hover,
            .metismenu a:focus,
            .metismenu a:active {
                color: {{ $mainColor }} !important;
            }

            .metismenu .mm-active > a {
                background-color: rgba({{ $mainColorRgb }}, 0.1) !important;
            }

            /* Secondary Color Styles */
            @if($secondColor)
            .btn-secondary,
            .btn-secondary:focus {
                background-color: {{ $secondColor }} !important;
                border-color: {{ $secondColor }} !important;
            }

            .btn-secondary:hover,
            .btn-secondary:active,
            .btn-secondary.active {
                background-color: {{ $secondColor }} !important;
                border-color: {{ $secondColor }} !important;
                opacity: 0.9;
            }

            .btn-outline-secondary {
                color: {{ $secondColor }} !important;
                border-color: {{ $secondColor }} !important;
            }

            .btn-outline-secondary:hover,
            .btn-outline-secondary:active,
            .btn-outline-secondary.active {
                background-color: {{ $secondColor }} !important;
                border-color: {{ $secondColor }} !important;
                color: #fff !important;
            }

            .text-secondary {
                color: {{ $secondColor }} !important;
            }

            .bg-secondary {
                background-color: {{ $secondColor }} !important;
            }

            .border-secondary {
                border-color: {{ $secondColor }} !important;
            }

            .badge-secondary {
                background-color: {{ $secondColor }} !important;
                color: #fff !important;
            }
            @endif

            /* Alert with primary color */
            .alert-primary {
                background-color: rgba({{ $mainColorRgb }}, 0.1) !important;
                border-color: {{ $mainColor }} !important;
                color: {{ $mainColor }} !important;
            }

            /* Table row hover */
            .table-hover tbody tr:hover {
                background-color: rgba({{ $mainColorRgb }}, 0.05) !important;
            }
        </style>
    </head>

    <body>
        @php
            $fallbackLogo = asset('assets/images/logo.png');
            $defaultAvatar = asset('assets/null_profile.jpg');
        @endphp

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
                        @auth
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ $defaultAvatar }}"
                                    alt="Header Avatar" onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';">
                                <span class="d-none d-sm-inline-block ml-1">{{ auth()->user()->getName() }}</span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('serviceTechnique.setting') }}">
                                    <i class="mdi mdi-cog mr-2"></i>{{ __('Settings') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="mdi mdi-logout mr-2"></i>{{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <div class="navbar-brand-box">
                        <a href="{{ route('serviceTechnique.setting') }}" class="logo">
                            <img src="{{ $logoUrl }}" alt="{{ $communeName ?: 'Logo' }}" onerror="this.onerror=null;this.src='{{ $fallbackLogo }}';">
                        </a>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">{{ __('Menu') }}</li>

                            <li>
                                <a href="{{ route('serviceTechnique.setting') }}" class="waves-effect">
                                    <i class='bx bx-home-smile'></i>
                                    <span>{{ __('Dashboard') }}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('serviceTechnique.setting') }}" class="waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span>{{ __('Settings') }}</span>
                                </a>
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
                            <div class="col-12">
                                <div class="text-center">
                                    &copy; {{ date('Y') }} {{ $communeName ?: 'Parc Management' }}. {{ __('All rights reserved') }}.
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
        <script src="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/theme.js') }}"></script>

    </body>

</html>
