<x-admin.app>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-size-18">
                            <i class="fas fa-calendar-check mr-2 text-primary"></i>{{ __('Vérifier la disponibilité des conducteurs') }}
                        </h4>
                        <p class="text-muted mb-0">{{ __('Sélectionnez une période pour voir les conducteurs disponibles') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.drivers') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-filter mr-2"></i>{{ __('Filtres de période') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="availabilityForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">{{ __('Date début') }} <span class="text-danger">*</span></label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="start_date" 
                                               name="start_date" 
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_date">{{ __('Date fin') }} ({{ __('Optionnel') }})</label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="end_date" 
                                               name="end_date">
                                        <small class="form-text text-muted">{{ __('Laissez vide pour une mission permanente') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-search mr-2"></i>{{ __('Vérifier la disponibilité') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-users mr-2"></i>{{ __('Conducteurs disponibles') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="loadingMessage" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">{{ __('Chargement...') }}</span>
                            </div>
                            <p class="mt-2">{{ __('Recherche des conducteurs disponibles...') }}</p>
                        </div>
                        
                        <div id="noResultsMessage" class="alert alert-info" style="display: none;">
                            <i class="fas fa-info-circle mr-2"></i>{{ __('Aucun conducteur disponible pour la période sélectionnée.') }}
                        </div>

                        <div id="resultsTable" style="display: none;">
                            <table id="availableDriversTable" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Prénom') }}</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('CIN') }}</th>
                                        <th>{{ __('Téléphone') }}</th>
                                        <th>{{ __('Rôle') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="availableDriversTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dataTable = null;

        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (!startDate) {
                alert('{{ __("Veuillez sélectionner une date de début") }}');
                return;
            }

            if (endDate && endDate < startDate) {
                alert('{{ __("La date de fin doit être supérieure ou égale à la date de début") }}');
                return;
            }

            // Show loading
            document.getElementById('loadingMessage').style.display = 'block';
            document.getElementById('noResultsMessage').style.display = 'none';
            document.getElementById('resultsTable').style.display = 'none';

            // Destroy existing datatable if it exists
            if (dataTable) {
                dataTable.destroy();
                dataTable = null;
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : document.querySelector('input[name="_token"]') 
                    ? document.querySelector('input[name="_token"]').value
                    : '';

            // Make AJAX request
            fetch('{{ route("admin.driver.get_available") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    start_date: startDate,
                    end_date: endDate || null
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingMessage').style.display = 'none';

                if (data.success && data.drivers.length > 0) {
                    const tbody = document.getElementById('availableDriversTableBody');
                    tbody.innerHTML = '';

                    data.drivers.forEach(function(driver) {
                        const row = document.createElement('tr');
                        const createUrl = '{{ route("admin.mission_order.create") }}?driver_id=' + driver.id + '&start_date=' + startDate + (endDate ? '&end_date=' + endDate : '');
                        row.innerHTML = `
                            <td>${driver.first_name_fr || driver.first_name_ar || '-'}</td>
                            <td>${driver.last_name_fr || driver.last_name_ar || '-'}</td>
                            <td>${driver.cin || '-'}</td>
                            <td>${driver.phone || '-'}</td>
                            <td>${driver.role_fr || driver.role_ar || '-'}</td>
                            <td>
                                <a href="${createUrl}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus-circle mr-1"></i>{{ __('Créer ordre de mission') }}
                                </a>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });

                    document.getElementById('resultsTable').style.display = 'block';
                    
                    // Initialize DataTable if jQuery DataTables is available
                    if (typeof $.fn.DataTable !== 'undefined') {
                        if (dataTable) {
                            dataTable.destroy();
                        }
                        dataTable = $('#availableDriversTable').DataTable({
                            responsive: true,
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json'
                            },
                            pageLength: 10,
                            order: [[0, 'asc']]
                        });
                    }
                } else {
                    document.getElementById('noResultsMessage').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loadingMessage').style.display = 'none';
                alert('{{ __("Une erreur s\'est produite lors de la vérification de la disponibilité") }}');
            });
        });

        // Set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('start_date').setAttribute('min', today);
            document.getElementById('end_date').setAttribute('min', today);
        });
    </script>
</x-admin.app>

