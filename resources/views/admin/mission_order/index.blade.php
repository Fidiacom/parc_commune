<x-admin.app>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Orders de mission') }}</h4>

                    <form action="{{ route('admin.mission_order.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ __('Select Car') }}</label>
                            <select class="form-control @error('vehicule') is-invalid @enderror" data-toggle="select2" style="width: 100%" name="vehicule">
                                <option value="0">{{ __('Select') }}</option>
                                @foreach ($vehicules as $v)
                                    <option value="{{ $v->getId() }}">
                                        {{ $v->getBrand().' - '.$v->getModel().' - '.$v->getMatricule() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicule')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="">{{ __('Select Driver') }}</label>
                            <select class="form-control @error('driver') is-invalid @enderror" data-toggle="select2" style="width: 100%" name="driver">
                                <option value="0">{{ __('Select') }}</option>
                                @foreach ($drivers as $d)
                                    <option value="{{ $d->id }}">{{ $d->getFirstNameFr().' '.$d->getLastNameFr().' | '.$d->getCin() }}</option>
                                @endforeach
                            </select>
                            @error('driver')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="customCheck3" name="mission_order_type" onchange="togglePermanentFields()">
                                <label class="custom-control-label" for="customCheck3">{{ __('Le Voyage permanent') }}</label>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>{{ __('Date start') }}</label>
                            <input type="date" class="form-control date @error('start_date') is-invalid @enderror" name="start_date">
                            @error('start_date')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3" id="end_date_group">
                            <label>{{ __('Date End') }}</label>
                            <input type="date" class="form-control date @error('end_date') is-invalid @enderror" name="end_date" id="end_date">
                            @error('end_date')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Registration DateTime (Always shown) --}}
                        <div class="form-group mb-3">
                            <label for="registration_datetime">{{ __('Registration Date/Time') }}</label>
                            <input type="datetime-local" id="registration_datetime" class="form-control @error('registration_datetime') is-invalid @enderror" name="registration_datetime" value="{{ old('registration_datetime') }}">
                            @error('registration_datetime')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Mission Section (Only shown if NOT permanent) --}}
                        <div class="card mb-3" id="mission_section">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">{{ __('Mission') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="mission_fr">{{ __('Mission') }} ({{ __('Français') }})</label>
                                    <input type="text" id="mission_fr" class="form-control @error('mission_fr') is-invalid @enderror" name="mission_fr" placeholder="{{ __('Mission in French') }}" value="{{ old('mission_fr') }}">
                                    @error('mission_fr')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mission_ar">{{ __('Mission') }} ({{ __('العربية') }})</label>
                                    <input type="text" id="mission_ar" class="form-control @error('mission_ar') is-invalid @enderror" name="mission_ar" placeholder="{{ __('Mission in Arabic') }}" dir="rtl" value="{{ old('mission_ar') }}">
                                    @error('mission_ar')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Place to Go Section (Only shown if NOT permanent) --}}
                        <div class="card mb-3" id="place_togo_section">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">{{ __('Place to Go') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="place_togo_fr">{{ __('Place to Go') }} ({{ __('Français') }})</label>
                                    <input type="text" id="place_togo_fr" class="form-control @error('place_togo_fr') is-invalid @enderror" name="place_togo_fr" placeholder="{{ __('Place to Go in French') }}" value="{{ old('place_togo_fr') }}">
                                    @error('place_togo_fr')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="place_togo_ar">{{ __('Place to Go') }} ({{ __('العربية') }})</label>
                                    <input type="text" id="place_togo_ar" class="form-control @error('place_togo_ar') is-invalid @enderror" name="place_togo_ar" placeholder="{{ __('Place to Go in Arabic') }}" dir="rtl" value="{{ old('place_togo_ar') }}">
                                    @error('place_togo_ar')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarder') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div><!-- end col-->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">{{ __('Orders de mission') }}</h4>


                    <table id="datatable-buttons" class="table table-striped nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Driver name') }}</th>
                                <th>{{ __('Driver CIN') }}</th>
                                <th>{{ __('Car') }}</th>
                                <th>{{ __('matricule') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('From - To') }}</th>
                                <th>{{ __('Done at') }}</th>
                                <th>{{ __('Cree le') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($missionOrders as $missionOrder)
                            <tr @if ($missionOrder->getDoneAt() != null) @class(['bg-success', 'text-white']) style="--bs-bg-opacity: .5;" @endif>
                                <td>
                                    <a href="{{ route('admin.mission_order.edit', $missionOrder->getId()) }}">
                                        {{ ($missionOrder->driver->getFirstNameFr() ?: $missionOrder->driver->getFirstNameAr() ?: '') . ' ' . ($missionOrder->driver->getLastNameFr() ?: $missionOrder->driver->getLastNameAr() ?: '') }}
                                    </a>
                                </td>
                                <td>{{ $missionOrder->driver->getCin() ?: '-' }}</td>
                                <td>{{ $missionOrder->vehicule->getBrand().' - '.$missionOrder->vehicule->getModel() }}</td>
                                <td>{{ $missionOrder->vehicule->getMatricule() }}</td>
                                <td>{{ $missionOrder->getPermanent() ? 'permanent' : 'temporaire' }}</td>
                                <td>{{ $missionOrder->getStart().' | ' }} {{ $missionOrder->getPermanent() ? '-----' : ($missionOrder->getEnd() ?: '-') }}</td>
                                <td>
                                    {{ $missionOrder->getDoneAt() ?? '--------'  }}
                                </td>
                                <td>
                                    {{ $missionOrder->getCreatedAt() }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.mission_order.print', $missionOrder->getId()) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info" 
                                       title="{{ __('Print Order de Mission') }}">
                                        <i class="mdi mdi-printer"></i> {{ __('Print') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <script src="{{ asset('assets/js/mission_order/mission_order.js') }}"></script>
    </div>
    
    <script>
        function togglePermanentFields() {
            const isPermanent = document.getElementById('customCheck3').checked;
            const endDateGroup = document.getElementById('end_date_group');
            const missionSection = document.getElementById('mission_section');
            const placeTogoSection = document.getElementById('place_togo_section');
            
            if (isPermanent) {
                endDateGroup.style.display = 'none';
                missionSection.style.display = 'none';
                placeTogoSection.style.display = 'none';
                document.getElementById('end_date').value = '';
                document.getElementById('mission_fr').value = '';
                document.getElementById('mission_ar').value = '';
                document.getElementById('place_togo_fr').value = '';
                document.getElementById('place_togo_ar').value = '';
            } else {
                endDateGroup.style.display = 'block';
                missionSection.style.display = 'block';
                placeTogoSection.style.display = 'block';
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            togglePermanentFields();
        });
    </script>
</x-admin.app>

