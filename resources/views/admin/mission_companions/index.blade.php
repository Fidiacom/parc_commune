<x-admin.app>
    <div class="col-12">
        <div class="container mb-5">
            <form action="">
                <div class="text-right">
                    <a href="{{ route('admin.mission_companions.create') }}" type="button"
                        class="btn btn-primary waves-effect waves-light">{{ __('Add Companion') }}</a>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable-buttons" class="table table-striped nowrap">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('cin') }}</th>
                                                <th>{{ __('Cree le') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companions as $companion)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.mission_companions.edit', $companion->getId()) }}">
                                                        {{ $companion->getDisplayName() ?: '-' }}
                                                    </a>
                                                </td>
                                                <td>{{ $companion->getCin() ?: '-' }}</td>
                                                <td>{{ $companion->created_at }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.mission_companions.edit', $companion->getId()) }}"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="{{ __('Modifier') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.mission_companions.delete', $companion->getId()) }}"
                                                              method="POST"
                                                              class="d-inline delete-companion-form">
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
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-companion-form');
            var confirmMessage = "{{ __('Êtes-vous sûr de vouloir supprimer cet accompagnant?') }}";
            deleteForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</x-admin.app>
