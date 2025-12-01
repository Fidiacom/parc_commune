<x-admin.app>
    <div class="col-12">
        <div class="container mb-5">
            <form action="">

                <div class="text-right">
                    <a href="{{ route('admin.driver.check_availability') }}" type="button"
                        class="btn btn-info waves-effect waves-light mr-2">
                        <i class="fas fa-calendar-check mr-2"></i>{{ __('Vérifier la disponibilité') }}
                    </a>
                    <a href="{{ route('admin.drivers.create') }}" type="button"
                        class="btn btn-primary waves-effect waves-light">{{ ('Add new Driver') }}</a>
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
                                                <th>{{ __('First Name') }}</th>
                                                <th>{{ __('Last Name') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('cin') }}</th>
                                                <th>{{ __('telephone') }}</th>
                                                <th>{{ __('Categorie Permis') }}</th>
                                                <th>{{ __('Cree le') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($drivers as $d)

                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.driver.edit', $d->getId()) }}">
                                                        {{ $d->getFirstNameFr() ?: $d->getFirstNameAr() ?: '-' }}
                                                    </a>
                                                </td>
                                                <td>{{ $d->getLastNameFr() ?: $d->getLastNameAr() ?: '-' }}</td>
                                                <td>{{ $d->getRoleFr() ?: $d->getRoleAr() ?: '-' }}</td>
                                                <td>{{ $d->getCin() ?: '-' }}</td>
                                                <td>{{ $d->getPhone() ?: '-' }}</td>
                                                <td>
                                                    @foreach ($d->permis as $permi)
                                                        {{ $permi->label.' | ' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $d->created_at }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.driver.edit', $d->getId()) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="{{ __('Modifier') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.driver.delete', $d->getId()) }}" 
                                                              method="POST" 
                                                              class="d-inline delete-driver-form">
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

                                </div><!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-driver-form');
            var confirmMessage = "{{ __('Êtes-vous sûr de vouloir supprimer ce conducteur?') }}";
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
