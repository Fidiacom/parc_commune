<x-admin.app>
    <div class="col-12">
        <div class="container mb-5">
            <form action="">

                <div class="text-right">
                    <a href="{{ route('admin.drivers.create') }}" type="button" class="btn btn-primary waves-effect waves-light">Add new Driver</a>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="container">
                    <h4 class="card-title">Basic Data Table</h4>
                    <div class="row">
                        @foreach (range(1,8) as $item)
                        <div class="col-6 col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img class="rounded-circle w-50 mb-3" alt="avatar1" src="https://mdbcdn.b-cdn.net/img/new/avatars/9.webp" />

                                    <h4 class="card-title">Special title treatment</h4>
                                    <p class="card-text">With supporting text below as a natural lead-in to
                                        additional content.</p>
                                    <a href="#" class="btn btn-primary waves-effect waves-light">More details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</x-admin.app>
