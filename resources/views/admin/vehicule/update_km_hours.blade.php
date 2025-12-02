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
                            <table id="vehicule-update-km-hours-table" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ __('Véhicule') }}</th>
                                        <th>{{ __('KM Actuel') }}</th>
                                        <th>{{ __('Heures Actuelles') }}</th>
                                        <th class="text-center" style="min-width: 140px;">{{ __('Actions') }}</th>
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
                                            <form action="{{ route('admin.vehicule.update.km_hours', $vehicule->getId()) }}" method="POST" class="d-inline update-form">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="text" 
                                                           name="total_km" 
                                                           class="form-control form-control-sm km-input" 
                                                           value="{{ number_format($vehicule->getTotalKm(), 0, '', '') }}" 
                                                           required>
                                                    <span class="input-group-text">{{ __('KM') }}</span>
                                                </div>
                                        </td>
                                        <td>
                                                <div class="input-group">
                                                    <input type="text" 
                                                           name="total_hours" 
                                                           class="form-control form-control-sm hours-input" 
                                                           value="{{ $vehicule->getTotalHours() ? number_format($vehicule->getTotalHours(), 0, '', '') : '' }}" 
                                                           placeholder="{{ __('Heures') }}">
                                                    <span class="input-group-text">{{ __('H') }}</span>
                                                </div>
                                        </td>
                                        <td class="text-center" style="min-width: 120px; white-space: nowrap;">
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

    <style>
        /* Ensure Actions column is always visible on all screen sizes */
        #vehicule-update-km-hours-table th:nth-child(4),
        #vehicule-update-km-hours-table td:nth-child(4) {
            min-width: 140px !important;
            width: auto !important;
            display: table-cell !important;
        }
        
        /* Ensure button is always visible and properly sized */
        #vehicule-update-km-hours-table td:nth-child(4) .btn {
            min-width: 120px;
            white-space: nowrap;
        }
        
        /* Responsive adjustments for smaller screens */
        @media (max-width: 768px) {
            #vehicule-update-km-hours-table th:nth-child(4),
            #vehicule-update-km-hours-table td:nth-child(4) {
                min-width: 100px !important;
            }
            
            #vehicule-update-km-hours-table td:nth-child(4) .btn {
                min-width: 90px;
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
            
            #vehicule-update-km-hours-table td:nth-child(4) .btn i {
                margin-right: 0.25rem !important;
            }
        }
        
        @media (max-width: 576px) {
            #vehicule-update-km-hours-table td:nth-child(4) .btn {
                min-width: 80px;
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }
        }
        
        /* Prevent DataTables from hiding the Actions column */
        .dataTables_wrapper .dataTables_scrollBody table.dataTable th:nth-child(4),
        .dataTables_wrapper .dataTables_scrollBody table.dataTable td:nth-child(4) {
            display: table-cell !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent Enter key from submitting forms
            const kmInputs = document.querySelectorAll('.km-input');
            const hoursInputs = document.querySelectorAll('.hours-input');
            
            [...kmInputs, ...hoursInputs].forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        return false;
                    }
                });
            });

            // Prevent form submission on Enter key
            const forms = document.querySelectorAll('.update-form');
            forms.forEach(form => {
                form.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && e.target.tagName !== 'BUTTON') {
                        e.preventDefault();
                        return false;
                    }
                });
            });
            
            // Initialize DataTable for this specific table
            if (typeof $.fn.DataTable !== 'undefined') {
                // Get current locale from HTML lang attribute or default to 'fr'
                var locale = $('html').attr('lang') || 'fr';
                var isRTL = locale === 'ar';
                
                // DataTables language configuration
                var dtLanguage = {};
                if (locale === 'ar') {
                    dtLanguage = {
                        "sEmptyTable": "لا توجد بيانات متاحة في الجدول",
                        "sLoadingRecords": "جارٍ التحميل...",
                        "sProcessing": "جارٍ المعالجة...",
                        "sLengthMenu": "أظهر _MENU_ مدخلات",
                        "sZeroRecords": "لم يعثر على أية سجلات",
                        "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                        "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                        "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                        "sSearch": "ابحث:",
                        "oPaginate": {
                            "sFirst": "الأول",
                            "sPrevious": "السابق",
                            "sNext": "التالي",
                            "sLast": "الأخير"
                        }
                    };
                } else if (locale === 'en') {
                    dtLanguage = {
                        "sEmptyTable": "No data available in table",
                        "sLoadingRecords": "Loading...",
                        "sProcessing": "Processing...",
                        "sLengthMenu": "Show _MENU_ entries",
                        "sZeroRecords": "No matching records found",
                        "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                        "sInfoFiltered": "(filtered from _MAX_ total entries)",
                        "sSearch": "Search:",
                        "oPaginate": {
                            "sFirst": "First",
                            "sPrevious": "Previous",
                            "sNext": "Next",
                            "sLast": "Last"
                        }
                    };
                } else {
                    dtLanguage = {
                        "sEmptyTable": "Aucune donnée disponible dans le tableau",
                        "sLoadingRecords": "Chargement...",
                        "sProcessing": "Traitement en cours...",
                        "sLengthMenu": "Afficher _MENU_ entrées",
                        "sZeroRecords": "Aucun enregistrement correspondant trouvé",
                        "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                        "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
                        "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
                        "sSearch": "Rechercher :",
                        "oPaginate": {
                            "sFirst": "Premier",
                            "sPrevious": "Précédent",
                            "sNext": "Suivant",
                            "sLast": "Dernier"
                        }
                    };
                }
                
                // Initialize DataTable only if not already initialized
                if (!$.fn.DataTable.isDataTable('#vehicule-update-km-hours-table')) {
                    var table = $('#vehicule-update-km-hours-table').DataTable({
                        lengthChange: false,
                        buttons: ['copy', 'print', 'pdf'],
                        "language": dtLanguage,
                        "drawCallback": function () {
                            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                            // Force Actions column to be visible
                            $('#vehicule-update-km-hours-table th:nth-child(4), #vehicule-update-km-hours-table td:nth-child(4)').css({
                                'display': 'table-cell',
                                'min-width': '140px'
                            });
                        }
                    });
                    
                    // Append buttons to wrapper
                    table.buttons().container()
                        .appendTo('#vehicule-update-km-hours-table_wrapper .col-md-6:eq(0)');
                }
            }
        });
    </script>
</x-admin.app>

