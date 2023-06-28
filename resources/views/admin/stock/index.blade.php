<x-admin.app>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Stock</h4>

                    <form action="{{ route('admin.stock.store') }}" method="post">
                        @csrf
                        <div class="form-group d-flex w-100">
                            <div class="w-50 mx-2">
                                <label for="">Piece</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" >

                                @error('name')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="w-50 mx-2">
                                <label for="">Seille alert</label>
                                <input
                                    type="number"
                                    step="any"
                                    name="alert"
                                    class="form-control @error('alert') is-invalid @enderror"
                                >
                                @error('alert')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group d-flex w-100">
                            <div class="w-50 mx-2">
                                <label for="">Stock Actuel</label>
                                <input
                                    type="number"
                                    step="any"
                                    name="stockActuel"
                                    class="form-control @error('stockActuel') is-invalid @enderror"
                                >
                                @error('stockActuel')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="w-50 mx-2">
                                <label for="">Unite</label>

                                <select name="unitie" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach ($unities as $unitie)
                                    <option value="{{ $unitie->id }}">{{ $unitie->name }}</option>
                                    @endforeach
                                </select>
                                @error('alert')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div><!-- end col-->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Stock</h4>


                    <table id="datatable-buttons" class="table table-striped nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Label') }}</th>
                                <th>{{ __('Stock Actuel') }}</th>
                                <th>{{ __('Seuile alert') }}</th>
                                <th>{{ __('Unite') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($stocks as $s)
                            <tr>
                                <form action="" method="post">
                                    <td>
                                        <input type="text" class="form-control" value="{{ $s->name }}" name="name">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control" value="{{ $s->stock_actuel }}" name="stock_actuel">
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control" value="{{ $s->min_stock_alert }}" name="min_stock_alert">
                                    </td>
                                    <td>
                                        <select name="unitie" class="form-control">
                                            <option value="0">Select</option>
                                            @foreach ($unities as $unitie)
                                            <option value="{{ $unitie->id }}" @selected($unitie->id == $s->unitie->id)>{{ $unitie->name }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                    <td>{{ $s->created_at }}</td>
                                    <td class="d-flex">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Edit</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light ml-2">Delete</button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</x-admin.app>
