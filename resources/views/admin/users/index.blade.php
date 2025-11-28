<x-admin.app>
    <div class="col-12">
        <div class="container mb-5">
            <form action="">
                <div class="text-right">
                    <a href="{{ route('admin.users.create') }}" type="button"
                        class="btn btn-primary waves-effect waves-light">{{ __('Add new User') }}</a>
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
                                                <th>{{ __('Username') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Role') }}</th>
                                                <th>{{ __('Created At') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.users.edit', $user->getId()) }}">
                                                        {{ $user->getName() }}
                                                    </a>
                                                </td>
                                                <td>{{ $user->getUsername() ?: '-' }}</td>
                                                <td>{{ $user->getEmail() }}</td>
                                                <td>{{ $user->role ? $user->role->getLabel() : '-' }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.users.edit', $user->getId()) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="{{ __('Edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if($user->getId() !== auth()->id())
                                                        <form action="{{ route('admin.users.delete', $user->getId()) }}" 
                                                              method="POST" 
                                                              class="d-inline delete-user-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    title="{{ __('Delete') }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                        @endif
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
            const deleteForms = document.querySelectorAll('.delete-user-form');
            var confirmMessage = "{{ __('Are you sure you want to delete this user?') }}";
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

