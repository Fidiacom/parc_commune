<x-admin.app>
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <i class="mdi mdi-receipt mr-2"></i>{{ __('Bons de paiement') }}
                    </h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.payment_voucher.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="fas fa-plus-circle mr-2"></i>{{ __('Nouveau bon') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.payment_voucher.index') }}" 
                               class="btn btn-sm {{ !$currentCategory ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ __('Tous') }}
                            </a>
                            @foreach($categories as $key => $label)
                            <a href="{{ route('admin.payment_voucher.index.category', $key) }}" 
                               class="btn btn-sm {{ $currentCategory === $key ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $label }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vouchers Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            @if($currentCategory)
                                {{ $categories[$currentCategory] }}
                            @else
                                {{ __('Tous les bons de paiement') }}
                            @endif
                        </h4>

                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ __('Num de bon') }}</th>
                                        <th>{{ __('Num de facture') }}</th>
                                        <th>{{ __('Date de facture') }}</th>
                                        <th>{{ __('Montant') }}</th>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('KM') }}</th>
                                        <th>{{ __('Fournisseur') }}</th>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vouchers as $voucher)
                                    <tr>
                                        <td>
                                            <strong>{{ $voucher->getVoucherNumber() }}</strong>
                                        </td>
                                        <td>{{ $voucher->getInvoiceNumber() ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($voucher->getInvoiceDate())->format('d/m/Y') }}</td>
                                        <td>
                                            <strong class="text-success">{{ number_format($voucher->getAmount(), 2, ',', ' ') }} {{ __('DH') }}</strong>
                                        </td>
                                        <td>
                                            @if($voucher->vehicule)
                                                {{ $voucher->vehicule->getBrand() }} - {{ $voucher->vehicule->getModel() }}
                                                <br>
                                                <small class="text-muted">{{ $voucher->vehicule->getMatricule() }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ number_format($voucher->getVehicleKm(), 0, ',', ' ') }} {{ __('KM') }}</td>
                                        <td>{{ $voucher->getSupplier() ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $categories[$voucher->getCategory()] ?? $voucher->getCategory() }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.payment_voucher.show', $voucher->getId()) }}" 
                                                   class="btn btn-sm btn-info waves-effect waves-light" 
                                                   title="{{ __('Voir') }}">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payment_voucher.edit', $voucher->getId()) }}" 
                                                   class="btn btn-sm btn-primary waves-effect waves-light" 
                                                   title="{{ __('Modifier') }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger waves-effect waves-light" 
                                                        onclick="deleteVoucher('{{ $voucher->getId() }}')"
                                                        title="{{ __('Supprimer') }}">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </div>
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

    <form action="{{ route('admin.payment_voucher.delete', '') }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>

    <script>
        $(document).ready(function() {
            // Destroy existing DataTable instance if it exists (from global initialization)
            if ($.fn.DataTable.isDataTable('#datatable-buttons')) {
                $('#datatable-buttons').DataTable().destroy();
            }

            // Initialize DataTable with responsive configuration
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'print', 'pdf'],
                responsive: {
                    details: {
                        type: 'column'
                    }
                },
                columnDefs: [
                    {
                        // Actions column (last column) - highest priority (last to hide)
                        targets: -1,
                        responsivePriority: 1,
                        orderable: false
                    }
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
                    }
                },
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });

            // Append buttons to the wrapper
            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        });

        function deleteVoucher(id) {
            Swal.fire({
                title: "{{ __('Êtes-vous sûr?') }}",
                text: "{{ __('Vous ne pourrez pas annuler cette action!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('Oui, supprimer!') }}",
                cancelButtonText: "{{ __('Annuler') }}"
            }).then(function (result) {
                if (result.value) {
                    document.getElementById("deleteForm").action = "{{ route('admin.payment_voucher.delete', '') }}/" + id;
                    document.getElementById("deleteForm").submit();
                }
            });
        }
    </script>
</x-admin.app>

