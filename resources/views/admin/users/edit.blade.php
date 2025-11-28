<x-admin.app>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('Edit User') }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->getId()) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" placeholder="{{ __('Name') }}" value="{{ old('name', $user->getName()) }}" required>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" 
                                       name="username" placeholder="{{ __('Username') }}" value="{{ old('username', $user->getUsername()) }}" required>
                                @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" placeholder="{{ __('Email') }}" value="{{ old('email', $user->getEmail()) }}" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }} <small class="text-muted">({{ __('Leave blank to keep current password') }})</small></label>
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" placeholder="{{ __('New Password') }}">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input type="password" id="password_confirmation" class="form-control" 
                                       name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                            </div>

                            <div class="form-group">
                                <label for="role_id">{{ __('Role') }}</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" 
                                        id="role_id" name="role_id" required>
                                    <option value="">{{ __('Select a role') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->getId() }}" 
                                                {{ old('role_id', $user->getRoleId()) == $role->getId() ? 'selected' : '' }}>
                                            {{ $role->getLabel() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Update') }}</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary waves-effect waves-light">{{ __('Cancel') }}</a>
                            </div>
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row-->
    </div> <!-- container-fluid -->
</x-admin.app>

