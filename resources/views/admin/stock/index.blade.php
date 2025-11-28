<x-admin.app>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Stock') }}</h4>

                    <form action="{{ route('admin.stock.store') }}" method="post">
                        @csrf
                        <div class="form-group d-flex w-100">
                            <div class="w-50 mx-2">
                                <label for="">{{ __('Piece') }}</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" >

                                @error('name')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="w-50 mx-2">
                                <label for="">{{ __('Seille alert') }}</label>
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
                                <label for="">{{ __('Stock Actuel') }}</label>
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
                                <label for="">{{ __('Unite') }}</label>

                                <select name="unitie" class="form-control">
                                    <option value="0">{{ __('Select') }}</option>
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
                            <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Sauvgarder') }}</button>
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

                    <h4 class="card-title">{{ __('Stock') }}</h4>


                    <table id="datatable-buttons" class="table table-striped nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Label') }}</th>
                                <th>{{ __('Stock Actuel') }}</th>
                                <th>{{ __('Seuile alert') }}</th>
                                <th>{{ __('Unite') }}</th>
                                <th>{{ __('Cree le') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($stocks as $s)
                            <tr>
                                <form action="{{ route('admin.stock.update', $s->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <td>
                                        <input type="text" class="form-control @error('nameUpdate') is-invalid @enderror" value="{{ $s->name }}" name="nameUpdate">
                                        @error('nameUpdate')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <span>{{ $s->stock_actuel }}</span>
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control @error('min_stock_alertUpdate') is-invalid @enderror" value="{{ $s->min_stock_alert }}" name="min_stock_alertUpdate">
                                        @error('min_stock_alertUpdate')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <select name="unitieUpdate" class="form-control @error('unitieUpdate') is-invalid @enderror">
                                            <option value="0">{{ __('Select') }}</option>
                                            @foreach ($unities as $unitie)
                                            <option value="{{ $unitie->id }}" @selected($unitie->id == $s->unitie->id)>{{ $unitie->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unitieUpdate')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </td>
                                    <td>{{ $s->created_at }}</td>
                                    <td class="d-flex">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Modifier') }}</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light ml-2" onclick="deleteStock({{ $s->id }})">{{ __('Supprimer') }}</button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <form action="{{ route('admin.stock.destroy') }}" method="POST" id="deleteForm">
            @csrf
            @method('delete')
            <input type="hidden" id="stockId" name="stockId">
        </form>

        <script>
            function deleteStock(id)
            {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(function (result) {
                    if (result.value) {
                        document.getElementById("stockId").value = id;
                        $("#deleteForm").submit();
                    }
                });

            }
        </script>
    </div>
</x-admin.app>
