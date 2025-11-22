<x-admin.app>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.vehicule.create') }}" class="btn btn-primary waves-effect waves-light mb-4">{{ ('Ajout vehicule') }}</a>

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('marque') }}</th>
                                <th>{{ __('model') }}</th>
                                <th>{{ __('matricule') }}</th>
                                <th>{{ __('total KM') }}</th>
                                <th>{{ __('fuel type') }}</th>
                                <th>{{ __('Tire Size') }}</th>
                                <th>{{ __('Files') }}</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($vehicules as $vehicule)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.vehicule.edit', $vehicule->getId()) }}">
                                        {{ $vehicule->getBrand() }}
                                    </a>
                                </td>
                                <td>{{ $vehicule->getModel() }}</td>
                                <td>{{ $vehicule->getMatricule() }}</td>
                                <td>{{ $vehicule->getTotalKm() }}</td>
                                <td>{{ $vehicule->getFuelType() }}</td>
                                <td>{{ $vehicule->getTireSize() ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $vehicule->attachments_count > 0 ? 'success' : 'secondary' }}">
                                        <i class="fas fa-{{ $vehicule->attachments_count > 0 ? 'file-alt' : 'file' }}"></i>
                                        {{ $vehicule->attachments_count ?? 0 }} {{ __('files') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</x-admin.app>
