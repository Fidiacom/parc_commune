<x-admin.app>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Stock</h4>

                    <form action="" method="post">
                        @csrf

                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">Equipement </label>
                                <select class="form-control @error('stock') is-invalid @enderror" data-toggle="select2" style="width: 100%" name="stock">
                                    <option value="0">Select</option>
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
                                <label for="">Qte Entree</label>

                                <input type="text" class="form-control" name="qte_entree">
                                @error('alert')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">Supplier name : </label>

                                <input type="text" class="form-control" name="qte_entree">
                                @error('alert')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="w-100 mx-2">
                                <label for="">Vignette : </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="vignetteFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
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
</x-admin.app>
