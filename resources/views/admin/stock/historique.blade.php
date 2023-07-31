<x-admin.app>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Stock</h4>


                    <table id="datatable-buttons" class="table table-striped nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Quantite') }}</th>
                                <th>{{ __('Supplier name') }}</th>
                                <th>{{ __('Document') }}</th>
                                <th>{{ __('Qte actuel') }}</th>
                                <th>{{ __('Created At') }}</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($historiques as $h)
                            <tr>
                                <td>{{ isset($h->stock) ? $h->stock->name : 'deleted' }}</td>
                                <td>
                                    {{ $h->type }}
                                    @if ($h->type == 'sortie')
                                    <a href="{{ route('admin.vehicule.edit', $h->vehicule_id) }}">
                                        {{ '('.$h->matricule.')' }}
                                    </a>
                                    @endif
                                </td>
                                <td>{{ $h->quantite }}</td>
                                <td>{{ $h->suppliername }}</td>
                                <td>
                                    @if ($h->type == 'sortie')
                                        @if (isset($h->document))
                                            <a href="{{ asset($h->document) }}" target="_blank">
                                                {{ __('Vignette') }}
                                            </a>
                                        @else
                                            {{ '-----------' }}
                                        @endif
                                    @else

                                        @if (isset($h->document))
                                        <a href="{{ asset($h->document) }}" target="_blank">
                                            {{ __('Document') }}
                                        </a>
                                        @else
                                            {{ '-----------' }}
                                        @endif
                                    @endif
                                </td>
                                <td>{{ isset($h->stock) ? $h->stock->stock_actuel : '-----' }}</td>
                                <td>{{ $h->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->


    </div>
</x-admin.app>
