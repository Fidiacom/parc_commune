<x-admin.app>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center min-vh-100">
                    <div class="w-100 d-block">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center mb-4 mt-3">
                                            <a href="index.html">
                                                <span><img src="assets/images/logo-dark.png" alt="" height="26"></span>
                                            </a>
                                        </div>
                                        <div class="mt-4 pt-3 text-center">
                                            <div class="row justify-content-center">
                                                <div class="col-6 my-4">
                                                    <img src="{{ asset('assets/images/404-error.svg') }}" title="invite.svg">
                                                </div>
                                            </div>
                                            <h3 class="expired-title mb-4 mt-3">{{ __('Véhicule introuvable') }}</h3>
                                            <p class="text-muted mt-3">{{ __('Il semble que vous ayez pris un mauvais virage. Ne vous inquiétez pas... cela arrive aux meilleurs d\'entre nous. Vous pourriez vouloir vérifier votre connexion Internet.') }}</p>
                                        </div>

                                        <div class="mb-3 mt-4 text-center">
                                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-block">{{ __('Retour à l\'accueil') }}</a>
                                        </div>
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
</x-admin.app>
