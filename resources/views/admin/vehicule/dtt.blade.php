<x-admin.app>

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">
                            {{ __('Pneus/Vidange/Chaine de distribution') }}
                        </h4>

                        <ul class="nav nav-tabs nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#vidange" data-toggle="tab" aria-expanded="false" class="nav-link  @if (!$errors->any() || $errors->has('km_actuel_vidange')) active @endif)">

                                    <span class=" d-lg-block">{{ __('Vidange') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#timingChaine" data-toggle="tab" aria-expanded="true" class="nav-link @error('km_actuel_timichaine') active @enderror">

                                    <span class=" d-lg-block">{{ __('Chaine de distribution') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#pneus" data-toggle="tab" aria-expanded="false" class="nav-link @error('km_actuel_pneu') active @enderror">

                                    <span class="d-lg-block">{{ __('Pneus') }}</span>
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div class="tab-pane @if (!$errors->any() || $errors->has('km_actuel_vidange')) active @endif)" id="vidange">
                                <form action="{{ route('admin.drain.update', $vehicule->getId()) }}"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>
                                            {{ __('KM actuel |') }}
                                            <span>
                                                {{ 'minimum: '. $vehicule->getTotalKm() }}
                                            </span>
                                            @error('km_actuel_vidange')
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </label>

                                        <div class="input-group">
                                            <input type="number" step="any"
                                                min="{{ $vehicule->getTotalKm() }}"
                                                class="form-control @error('km_actuel') is-invalid @enderror"
                                                name="km_actuel_vidange">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-dark waves-effect waves-light"
                                                    type="button">{{ __('Change') }}</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">


                                                <table class="table nowrap dtt">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Start Km') }}</th>
                                                            <th>{{ __('Next Km') }}</th>
                                                            <th>{{ __('Cree le') }}</th>
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
                                <form action="{{ route('admin.timingchaine.update', $vehicule->getId()) }}"
                                    method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>
                                            {{ __('KM actuel |') }}
                                            <span>
                                                {{ 'minimum: '. $vehicule->getTotalKm() }}
                                            </span>
                                            @error('km_actuel_timichaine')
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </label>

                                        <div class="input-group">
                                            <input type="number" step="any"
                                                min="{{ $vehicule->getTotalKm() }}"
                                                class="form-control @error('km_actuel_timichaine') is-invalid @enderror"
                                                name="km_actuel_timichaine">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-dark waves-effect waves-light"
                                                    type="button">{{ __('Change') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <table class="table nowrap dtt">
                                                    <thead>
                                                        <tr>

                                                            <th>{{ __('Start Km') }}</th>
                                                            <th>{{ __('Next Km') }}</th>
                                                            <th>{{ __('Cree le') }}</th>
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
                                        <form action="{{ route('admin.pneu.update', $vehicule->getId()) }}" method="POST" class="form-group">
                                            @csrf
                                            <div class="form-group mb-0">
                                                <label>
                                                    {{ __('KM Actuel') }}
                                                    {{ 'minimum: '. $vehicule->getTotalKm() }}
                                                </label>
                                                <div class="input-group">
                                                    <input type="number"
                                                        step="any"
                                                        class="form-control"
                                                        name="km_actuel_pneu"
                                                        min="{{ $vehicule->getTotalKm() }}"
                                                        >
                                                </div>
                                            </div>

                                            <div class="form-group mb-0 mt-2">
                                                <label>{{ __('Position') }}</label>

                                                <div>
                                                    <select class="form-control select2-multiple w-100" name="positions[]" data-toggle="select2" multiple="multiple" style="width:100%" data-placeholder="{{ __('Choisir...') }}">
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
                                                    type="button">{{ __('Change') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ __('Tableau de données de base') }}</h4>
                                                <table class="table nowrap dtt">
                                                    <thead>
                                                        <tr>

                                                            <th>{{ __('Pneu Position') }}</th>
                                                            <th>{{ __('Start Km') }}</th>
                                                            <th>{{ __('Next Km') }}</th>
                                                            <th>{{ __('Cree le') }}</th>
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
