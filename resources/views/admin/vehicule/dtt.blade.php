<x-admin.app>

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Tabs Justified</h4>
                        <p class="card-subtitle mb-4">Example of justified tabs.</p>

                        <ul class="nav nav-tabs nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link active">

                                    <span class=" d-lg-block">Vidange</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link">

                                    <span class=" d-lg-block">Vidange</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings1" data-toggle="tab" aria-expanded="false" class="nav-link">

                                    <span class="d-lg-block">Chaine de distribution</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="home1">
                                <form action="{{ route('admin.drain.update', Crypt::encrypt($vehicule->vidange->id)) }}" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>threshold_km
                                        @error('threshold_km')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('threshold_km') is-invalid @enderror" name="threshold_km" value="{{ $vehicule->vidange->threshold_km }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-dark waves-effect waves-light" type="button">Change</button>
                                            </div>
                                        </div>

                                    </div>
                                    @error('threshold_km')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </form>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Basic Data Table</h4>


                                                <table id="basic-datatable" class="table nowrap">
                                                    <thead>
                                                        <tr>

                                                            <th>Start Km</th>
                                                            <th>Next Km</th>
                                                            <th>Created At</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        @foreach ($vehicule->vidange->vidange_historique as $vh)
                                                        <tr>
                                                            <td>{{ $vh->current_km }}</td>
                                                            <td>{{ $vh->next_km_for_drain }}</td>
                                                            <td>{{ $vh->created_at }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div> <!-- end card body-->
                                        </div> <!-- end card -->
                                    </div><!-- end col-->
                                </div>
                            </div>

                            <div class="tab-pane show" id="profile1">
                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
                                <p class="mb-0">Leggings occaecat dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p>
                            </div>
                            <div class="tab-pane" id="settings1">
                                <p>Food truck quinoa dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p>
                                <p class="mb-0">Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>

    </div> <!-- container-fluid -->
</x-admin.app>
