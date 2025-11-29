<x-admin.app>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">{{ __('Orders de mission') }}</h4>
                        <a href="{{ route('admin.mission_order.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus"></i> {{ __('Create Order de mission') }}
                        </a>
                    </div>


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
</x-admin.app>

