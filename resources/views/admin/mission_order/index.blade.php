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
                                    <option value="{{ $d->id }}">{{ $d->full_name. ' | '.$d->cin }}</option>
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
                                <input type="checkbox" class="custom-control-input" id="customCheck3" name="mission_order_type">
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

                        <div class="form-group mb-3">
                            <label>{{ __('Date End') }}</label>
                            <input type="date" class="form-control date @error('end_date') is-invalid @enderror" name="end_date" id="end_date">
                            @error('end_date')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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
                            <tr @if ($missionOrder->done_at != null) @class(['bg-success', 'text-white']) style="--bs-bg-opacity: .5;" @endif>
                                <td>
                                    <a href="{{ route('admin.mission_order.edit', Crypt::encrypt($missionOrder->id)) }}">
                                        {{ $missionOrder->driver->full_name }}
                                    </a>
                                </td>
                                <td>{{ $missionOrder->driver->cin }}</td>
                                <td>{{ $missionOrder->vehicule->brand.' - '.$missionOrder->vehicule->model }}</td>
                                <td>{{ $missionOrder->vehicule->matricule }}</td>
                                <td>{{ $missionOrder->permanent ? 'permanent' : 'temporaire' }}</td>
                                <td>{{ $missionOrder->start.' | ' }} {{ $missionOrder->permanent ? '-----' : $missionOrder->end }}</td>
                                <td>
                                    {{ $missionOrder->done_at ?? '--------'  }}
                                </td>
                                <td>
                                    {{ $missionOrder->created_at }}
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
</x-admin.app>

