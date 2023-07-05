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
                                <a href="#vidange" data-toggle="tab" aria-expanded="false" class="nav-link  @if (!$errors->any() || $errors->has('km_actuel_vidange')) active @endif)">

                                    <span class=" d-lg-block">Vidange</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#timingChaine" data-toggle="tab" aria-expanded="true" class="nav-link @error('km_actuel_timichaine') active @enderror">

                                    <span class=" d-lg-block">Chaine de distribution</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#pneus" data-toggle="tab" aria-expanded="false" class="nav-link @error('km_actuel_pneu') active @enderror">

                                    <span class="d-lg-block">Pneus</span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div class="tab-pane @if (!$errors->any() || $errors->has('km_actuel_vidange')) active @endif)" id="vidange">
                                <form action="{{ route('admin.drain.update', Crypt::encrypt($vehicule->id)) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>
                                            KM actuel |
                                            <span>
                                                {{ 'minimum: '. $vehicule->total_km }}
                                            </span>
                                            @error('km_actuel_vidange')
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </label>

                                        <div class="input-group">
                                            <input type="number" step="any"
                                                min="{{ $vehicule->total_km }}"
                                                class="form-control @error('km_actuel') is-invalid @enderror"
                                                name="km_actuel_vidange">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-dark waves-effect waves-light"
                                                    type="button">Change</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Basic Data Table</h4>


                                                <table class="table nowrap dtt">
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

                            <div class="tab-pane @error('km_actuel_timichaine') active @enderror" id="timingChaine">
                                <form action="{{ route('admin.timingchaine.update', Crypt::encrypt($vehicule->id)) }}"
                                    method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>
                                            KM actuel |
                                            <span>
                                                {{ 'minimum: '. $vehicule->total_km }}
                                            </span>
                                            @error('km_actuel_timichaine')
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </label>

                                        <div class="input-group">
                                            <input type="number" step="any"
                                                min="{{ $vehicule->total_km }}"
                                                class="form-control @error('km_actuel_timichaine') is-invalid @enderror"
                                                name="km_actuel_timichaine">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-dark waves-effect waves-light"
                                                    type="button">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Basic Data Table</h4>


                                                <table class="table nowrap dtt">
                                                    <thead>
                                                        <tr>

                                                            <th>Start Km</th>
                                                            <th>Next Km</th>
                                                            <th>Created At</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        @foreach ($vehicule->timing_chaine->timingchaine_historique as $vh)
                                                        <tr>
                                                            <td>{{ $vh->current_km }}</td>
                                                            <td>{{ $vh->next_km_for_change }}</td>
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

                            <div class="tab-pane @error('km_actuel_pneu') active @enderror" id="pneus">
                                <div class="row">

                                    <div class="col-12">
                                        <form action="{{ route('admin.pneu.update', Crypt::encrypt($vehicule->id)) }}" method="POST" class="form-group">
                                            @csrf
                                            <div class="form-group mb-0">
                                                <label>
                                                    KM Actuel
                                                    {{ 'minimum: '. $vehicule->total_km }}
                                                </label>
                                                <div class="input-group">
                                                    <input type="number"
                                                        step="any"
                                                        class="form-control"
                                                        name="km_actuel_pneu"
                                                        min="{{ $vehicule->total_km }}"
                                                        >
                                                </div>
                                            </div>

                                            <div class="form-group mb-0 mt-2">
                                                <label>Position: </label>

                                                <div>
                                                    <select class="form-control select2-multiple w-100" name="positions[]" data-toggle="select2" multiple="multiple" style="width:100%" data-placeholder="Choose ...">
                                                        @foreach ($vehicule->pneu as $pneu)
                                                            <option value="{{ $pneu->id }}">{{ 'Position: '.$pneu->tire_position }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('km_actuel_pneu')
                                                <div id="validationServerUsernameFeedback" class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <button type="submit" class="btn btn-dark waves-effect waves-light"
                                                    type="button">Change</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Basic Data Table</h4>
                                                <table class="table nowrap dtt">
                                                    <thead>
                                                        <tr>

                                                            <th>Pneu Position</th>
                                                            <th>Start Km</th>
                                                            <th>Next Km</th>
                                                            <th>Created At</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        @foreach ($historiquePneu as $h)
                                                        <tr>
                                                            <td>{{ $h->tire_position }}</td>
                                                            <td>{{ $h->current_km }}</td>
                                                            <td>{{ $h->next_km_for_change }}</td>
                                                            <td>{{ $h->created_at }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div> <!-- end card body-->
                                        </div> <!-- end card -->
                                    </div><!-- end col-->
                                </div>
                            </div>

                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>

    </div> <!-- container-fluid -->
</x-admin.app>
