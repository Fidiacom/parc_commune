<x-admin.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="bx bx-car mr-2 text-primary"></i>{{ __('Mise à jour KM et Heures') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Mettez à jour le kilométrage et les heures des véhicules') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('KM Actuel') }}</th>
                                        <th>{{ __('Heures Actuelles') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehicules as $vehicule)
                                    <tr>
                                        <td>
                                            <strong>{{ $vehicule->getBrand() }} - {{ $vehicule->getModel() }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $vehicule->getMatricule() }}</small>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.vehicule.update.km_hours', $vehicule->getId()) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="text" 
                                                           name="total_km" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ number_format($vehicule->getTotalKm(), 0, '', '') }}" 
                                                           required>
                                                    <span class="input-group-text">{{ __('KM') }}</span>
                                                </div>
                                        </td>
                                        <td>
                                                <div class="input-group">
                                                    <input type="text" 
                                                           name="total_hours" 
                                                           class="form-control form-control-sm" 
                                                           value="{{ $vehicule->getTotalHours() ? number_format($vehicule->getTotalHours(), 0, '', '') : '' }}" 
                                                           placeholder="{{ __('Heures') }}">
                                                    <span class="input-group-text">{{ __('H') }}</span>
                                                </div>
                                        </td>
                                        <td>
                                                <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light">
                                                    <i class="mdi mdi-content-save mr-1"></i>{{ __('Mettre à jour') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app>

