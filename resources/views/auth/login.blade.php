

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

        </style>
    </head>

<body class="bg-primary">

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
                                                        Fidiacom
                                                    </span>
                                                </a>
                                            </div>
                                            <form action="{{ route('login') }}" method="POST" class="p-2">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="emailaddress">{{ __('Email') }}</label>
                                                    <input class="form-control" type="email" id="emailaddress" name="email" required placeholder="john@deo.com">

                                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
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
