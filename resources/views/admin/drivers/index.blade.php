<x-admin.app>
    <div class="col-12">
        <div class="container mb-5">
            <form action="">

                <div class="text-right">
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
                                                <th>{{ __('Full Name') }}</th>
                                                <th>{{ __('cin') }}</th>
                                                <th>{{ __('telephone') }}</th>
                                                <th>{{ __('Categorie Permis') }}</th>
                                                <th>{{ __('Cree le') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($drivers as $d)

                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.driver.edit', Crypt::encrypt($d->id)) }}">
                                                        {{ $d->full_name }}
                                                    </a>
                                                </td>
                                                <td>{{ $d->cin }}</td>
                                                <td>{{ $d->phone }}</td>
                                                <td>
                                                    @foreach ($d->permis as $permi)
                                                        {{ $permi->label.' | ' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $d->created_at }}</td>
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
</x-admin.app>
