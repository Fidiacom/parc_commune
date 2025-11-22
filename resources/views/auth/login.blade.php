

<!DOCTYPE html>
<html lang="en" dir="rtl">

    <head>
        <meta charset="utf-8" />
        <title>Parking management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Application de gestion de parking" name="description" />
        <meta content="Fidiacom" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/theme.min.css" rel="stylesheet" type="text/css" />
        <style>
            .btn-primary{
                background-color: {{ $mainColor ?? '#397D3C' }} !important;
                border-color: {{ $mainColor ?? '#397D3C' }} !important;
            }
            @if(isset($secondColor) && $secondColor)
            .btn-secondary,
            .badge-secondary{
                background-color: {{ $secondColor }} !important;
                border-color: {{ $secondColor }} !important;
            }
            @endif
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
                                                        <img src="{{ asset('assets/images/logo.png') }}" style="width: 8rem" alt="">
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
