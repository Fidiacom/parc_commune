<x-admin.app>

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">{{ __('edit condicteur') }}</h4>
                    <div>
                        <a href="{{ route('admin.driver.check_availability') }}" class="btn btn-outline-info btn-sm mr-2">
                            <i class="fas fa-calendar-check mr-2"></i>{{ __('Vérifier disponibilité') }}
                        </a>
                        <a href="{{ route('admin.drivers') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.driver.update', $driver->getId()) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Image Section --}}
                            <div class="form-group">
                                <div>
                                    <div class="col-xl-5 mx-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ __('Image') }}</h4>
                                                <p class="card-subtitle mb-4">{{ __('la taile maximum est') }}</p>
                                                <input type="file" class="dropify" data-max-file-size="5M" name="image" accept="image/*" data-default-file="{{ asset($driver->image) }}"/>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col -->
                                    @error('image')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Arabic Data Section --}}
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">{{ __('Données en arabe') }} ({{ __('العربية') }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="first_name_ar">{{ __('First Name') }}</label>
                                        <input
                                            type="text"
                                            id="first_name_ar"
                                            class="form-control @error('first_name_ar') is-invalid @enderror"
                                            name="first_name_ar"
                                            placeholder="{{ __('First Name in Arabic') }}"
                                            dir="rtl"
                                            value="{{ old('first_name_ar', $driver->getFirstNameAr()) }}">
                                        @error('first_name_ar')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name_ar">{{ __('Last Name') }}</label>
                                        <input
                                            type="text"
                                            id="last_name_ar"
                                            class="form-control @error('last_name_ar') is-invalid @enderror"
                                            name="last_name_ar"
                                            placeholder="{{ __('Last Name in Arabic') }}"
                                            dir="rtl"
                                            value="{{ old('last_name_ar', $driver->getLastNameAr()) }}">
                                        @error('last_name_ar')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="role_ar">{{ __('Role') }}</label>
                                        <input
                                            type="text"
                                            id="role_ar"
                                            class="form-control @error('role_ar') is-invalid @enderror"
                                            name="role_ar"
                                            placeholder="{{ __('Role in Arabic') }}"
                                            dir="rtl"
                                            value="{{ old('role_ar', $driver->getRoleAr()) }}">
                                        @error('role_ar')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- French Data Section --}}
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">{{ __('Données en français') }} ({{ __('Français') }})</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="first_name_fr">{{ __('First Name') }}</label>
                                        <input
                                            type="text"
                                            id="first_name_fr"
                                            class="form-control @error('first_name_fr') is-invalid @enderror"
                                            name="first_name_fr"
                                            placeholder="{{ __('First Name in French') }}"
                                            value="{{ old('first_name_fr', $driver->getFirstNameFr()) }}">
                                        @error('first_name_fr')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="last_name_fr">{{ __('Last Name') }}</label>
                                        <input
                                            type="text"
                                            id="last_name_fr"
                                            class="form-control @error('last_name_fr') is-invalid @enderror"
                                            name="last_name_fr"
                                            placeholder="{{ __('Last Name in French') }}"
                                            value="{{ old('last_name_fr', $driver->getLastNameFr()) }}">
                                        @error('last_name_fr')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="role_fr">{{ __('Role') }}</label>
                                        <input
                                            type="text"
                                            id="role_fr"
                                            class="form-control @error('role_fr') is-invalid @enderror"
                                            name="role_fr"
                                            placeholder="{{ __('Role in French') }}"
                                            value="{{ old('role_fr', $driver->getRoleFr()) }}">
                                        @error('role_fr')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- CIN --}}
                            <div class="form-group">
                                <label for="example-password">{{ __('cin') }}</label>
                                <input
                                    type="text"
                                    id="example-password"
                                    class="form-control  @error('cin') is-invalid @enderror"
                                    name="cin"
                                    value="{{ old('cin', $driver->getCin()) }}">
                                @error('cin')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- License --}}
                            <div class="form-group">
                                <div class="form-group mb-0">
                                    <label for="exampleFormControlInput1">{{ __('license') }}</label>

                                    <select class="form-control select2-multiple @error('permisType') is-invalid @enderror" data-toggle="select2" multiple="multiple" name="permisType[]" data-placeholder="permis ...">
                                        @foreach ($permis as $p)
                                            <option value="{{ $p->id }}" @selected($driver->permis->pluck('id')->contains($p->id))>{{ $p->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('permisType')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="form-group">
                                <label for="exampleFormControlInput1">{{ __('telephone') }}</label>
                                <input
                                    type="text"
                                    class="form-control  @error('phone') is-invalid @enderror"
                                    id="exampleFormControlInput1"
                                    name="phone"
                                    value="{{ old('phone', $driver->getPhone()) }}">
                                @error('phone')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group d-flex">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarde') }}</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light ml-2" onclick="deleteDriver()">{{ __('Supprimer') }}</button>
                            </div>

                        </form>
                        
                        {{-- Delete Form --}}
                        <form action="{{ route('admin.driver.delete', $driver->getId()) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card -->

                {{-- Availability Section --}}
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-check mr-2"></i>{{ __('Disponibilité du conducteur') }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($activeMissionOrders->count() > 0)
                            <div class="alert alert-warning">
                                <strong>{{ __('Mission(s) active(s)') }}:</strong> {{ $activeMissionOrders->count() }}
                            </div>
                            
                            <h6 class="mb-3">{{ __('Missions actives et à venir') }}:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Date début') }}</th>
                                            <th>{{ __('Date fin') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Véhicule') }}</th>
                                            <th>{{ __('Mission') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeMissionOrders as $mission)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($mission->getStart())->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($mission->isPermanent())
                                                        <span class="badge badge-danger">{{ __('Permanent') }}</span>
                                                    @elseif($mission->getEnd())
                                                        {{ \Carbon\Carbon::parse($mission->getEnd())->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($mission->isPermanent())
                                                        <span class="badge badge-danger">{{ __('Permanent') }}</span>
                                                    @else
                                                        <span class="badge badge-info">{{ __('Temporaire') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($mission->getVehicule())
                                                        {{ $mission->getVehicule()->getMatricule() ?? '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($mission->getMissionFr())
                                                        {{ $mission->getMissionFr() }}
                                                    @elseif($mission->getMissionAr())
                                                        {{ $mission->getMissionAr() }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle mr-2"></i>{{ __('Aucune mission active. Le conducteur est disponible.') }}
                            </div>
                        @endif
                    </div>
                </div>



            </div> <!-- end col -->

        </div>
        <!-- end row-->

    </div> <!-- container-fluid -->
    
    <script>
        function deleteDriver()
        {
            if(confirm("{{ __('Êtes-vous sûr de vouloir supprimer ce conducteur?') }}") == true)
            {
                document.getElementById("deleteForm").submit();
            }
        }
    </script>
</x-admin.app>
