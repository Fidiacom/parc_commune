

<!DOCTYPE html>
<html lang="en" dir="rtl">

    <head>
        <meta charset="utf-8" />
        <title>Parking management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Application de gestion de parking" name="description" />
        <meta content="Jamaycom" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/theme.min.css" rel="stylesheet" type="text/css" />
        <style>
            :root {
                --main-color: {{ $mainColor ?? '#397D3C' }};
                @if(isset($secondColor) && $secondColor)
                --second-color: {{ $secondColor }};
                @endif
            }

            /* Primary Color Styles */
            .btn-primary,
            .btn-primary:focus {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            .btn-primary:hover,
            .btn-primary:active,
            .btn-primary.active {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
                opacity: 0.9;
            }

            .btn-outline-primary {
                color: {{ $mainColor ?? '#397D3C' }} !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            .btn-outline-primary:hover,
            .btn-outline-primary:active,
            .btn-outline-primary.active {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
                color: #fff !important;
            }

            .text-primary {
                color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            .bg-primary {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            .border-primary {
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            .badge-primary {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
                color: #fff !important;
            }

            a {
                color: {{ $mainColor ?? '#397D3C' }};
            }

            a:hover {
                color: {{ $mainColor ?? '#397D3C' }};
                opacity: 0.8;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
                box-shadow: 0 0 0 0.2rem rgba({{ $mainColorRgb ?? '57, 125, 60' }}, 0.25) !important;
            }

            .custom-control-input:checked ~ .custom-control-label::before {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
            }

            /* Secondary Color Styles */
            @if(isset($secondColor) && $secondColor)
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
                background-color: rgba({{ $mainColorRgb ?? '57, 125, 60' }}, 0.1) !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
                color: {{ $mainColor ?? '#397D3C' }} !important;
            }
        </style>
    </head>

<body class="" style="background-color: #e9e9e9;">

    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block my-5">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-lg-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-center mb-4 mt-3">
                                                <a href="index.html">
                                                    <span class="h4">
                                                        @php
                                                            $fallbackLogo = asset('assets/images/base-logo.png');
                                                        @endphp
                                                        <img src="{{ $logoUrl ?? $fallbackLogo }}" style="width: 8rem" alt="" onerror="this.onerror=null;this.src='{{ $fallbackLogo }}';">
                                                    </span>
                                                </a>
                                            </div>
                                            <form action="{{ route('login') }}" method="POST" class="p-2">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="login">{{ __('Email ou nom d\'utilisateur') }}</label>
                                                    <input class="form-control" type="text" id="login" name="login" required placeholder="{{ __('Email ou nom d\'utilisateur') }}" value="{{ old('login') }}">

                                                    <x-input-error :messages="$errors->get('login')" class="mt-2 text-danger" />
                                                </div>
                                                <div class="form-group">
                                                    {{-- <a href="pages-recoverpw.html" class="text-muted float-right">Forgot your password?</a> --}}
                                                    <label for="password">{{ __('Mots de passe') }}</label>
                                                    <input class="form-control" type="password" required="" id="password" name="password" placeholder="{{ __('saisir votre mots de passe') }}">
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                                                </div>

                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary btn-block" type="submit"> {{ __('Connexion') }} </button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- end card-body -->
                                    </div>
                                    <!-- end card -->



                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div> <!-- end .w-100 -->
                    </div> <!-- end .d-flex -->
                </div> <!-- end col-->
            </div> <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/metismenu.min.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/simplebar.min.js"></script>

    <!-- App js -->
    <script src="assets/js/theme.js"></script>

</body>

</html>
