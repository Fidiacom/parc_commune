<x-admin.app>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Stock') }}</h4>

                    <form action="{{ route('admin.stock_history.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">{{ __('Equipement') }} </label>
                                <select class="form-control @error('stock') is-invalid @enderror" data-toggle="select2" style="width: 100%" name="stock_id">
                                    <option value="0">{{ __('Select') }}</option>
                                    @foreach ($stockNames as $stock)
                                        <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                    @endforeach
                                </select>
                                @error('stock')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">{{ __('Qte Entree') }}</label>

                                <input type="number" step="any" class="form-control" name="qte_entree">
                                @error('alert')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">{{ __('Supplier name') }}</label>

                                <input type="text" class="form-control" name="supplier_name">
                                @error('alert')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">{{ __('Document') }}</label>
                                <div class="">
                                    <input type="file" name="document">
                                </div>
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
</x-admin.app>
