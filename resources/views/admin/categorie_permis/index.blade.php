<x-admin.app>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{ __('Catégories de permis') }}</h4>
                
                <!-- Add New Category Form -->
                <div class="card mb-4" style="background-color: #f8f9fa;">
                    <div class="card-body">
                        <h5 class="mb-3">{{ __('Ajouter une nouvelle catégorie') }}</h5>
                        <form action="{{ route('admin.categorie_permis.store') }}" method="POST" id="add-categorie-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-semibold">{{ __('Libellé') }} <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               name="label" 
                                               id="new_label"
                                               class="form-control @error('label') is-invalid @enderror" 
                                               value="{{ old('label') }}" 
                                               placeholder="{{ __('Ex: A, B, C, D, E') }}"
                                               required>
                                        @error('label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                            <i class="fas fa-plus"></i> {{ __('Ajouter') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Categories Table -->
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Libellé') }}</th>
                                <th>{{ __('Créé le') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $categorie)
                            <tr data-id="{{ $categorie->getId() }}">
                                <td>{{ $categorie->getId() }}</td>
                                <td>
                                    <form action="{{ route('admin.categorie_permis.update', $categorie->getId()) }}" 
                                          method="POST" 
                                          class="inline-edit-form"
                                          data-id="{{ $categorie->getId() }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" 
                                               name="label" 
                                               class="form-control form-control-sm label-input" 
                                               value="{{ $categorie->getLabel() }}"
                                               data-original-value="{{ $categorie->getLabel() }}"
                                               data-id="{{ $categorie->getId() }}">
                                    </form>
                                </td>
                                <td>{{ $categorie->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary save-btn" 
                                                data-id="{{ $categorie->getId() }}"
                                                title="{{ __('Enregistrer') }}"
                                                style="display: none;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary cancel-btn" 
                                                data-id="{{ $categorie->getId() }}"
                                                title="{{ __('Annuler') }}"
                                                style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <form action="{{ route('admin.categorie_permis.destroy', $categorie->getId()) }}" 
                                              method="POST" 
                                              class="d-inline delete-categorie-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="{{ __('Supprimer') }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete confirmation
            const deleteForms = document.querySelectorAll('.delete-categorie-form');
            var confirmMessage = "{{ __('Êtes-vous sûr de vouloir supprimer cette catégorie?') }}";
            deleteForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                    }
                });
            });

            // Inline editing
            const labelInputs = document.querySelectorAll('.label-input');
            const saveButtons = document.querySelectorAll('.save-btn');
            const cancelButtons = document.querySelectorAll('.cancel-btn');

            labelInputs.forEach(function(input) {
                const id = input.getAttribute('data-id');
                const saveBtn = document.querySelector(`.save-btn[data-id="${id}"]`);
                const cancelBtn = document.querySelector(`.cancel-btn[data-id="${id}"]`);
                const form = input.closest('.inline-edit-form');
                const originalValue = input.getAttribute('data-original-value');

                // Show save/cancel buttons when input changes
                input.addEventListener('input', function() {
                    if (input.value !== originalValue) {
                        saveBtn.style.display = 'inline-block';
                        cancelBtn.style.display = 'inline-block';
                    } else {
                        saveBtn.style.display = 'none';
                        cancelBtn.style.display = 'none';
                    }
                });

                // Save on button click
                saveBtn.addEventListener('click', function() {
                    form.submit();
                });

                // Cancel - restore original value
                cancelBtn.addEventListener('click', function() {
                    input.value = originalValue;
                    saveBtn.style.display = 'none';
                    cancelBtn.style.display = 'none';
                });

                // Save on Enter key
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (input.value !== originalValue) {
                            form.submit();
                        }
                    }
                });

                // Cancel on Escape key
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        input.value = originalValue;
                        saveBtn.style.display = 'none';
                        cancelBtn.style.display = 'none';
                    }
                });
            });

            // Reset form after successful submission
            const addForm = document.getElementById('add-categorie-form');
            if (addForm) {
                addForm.addEventListener('submit', function(e) {
                    // Form will be reset after successful submission via page reload
                    // Or we could use AJAX here if needed
                });
            }
        });
    </script>
</x-admin.app>
