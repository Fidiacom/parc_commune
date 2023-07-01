<x-admin.app>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Return from Trip</h4>

                    <form action="{{ route('admin.trip.return', $trip->id) }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label>return Date</label>
                            <input type="date" class="form-control date @error('return_date') is-invalid @enderror" name="return_date">
                            @error('return_date')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Actual KM</label>
                            <input type="number" class="form-control @error('actual_km') is-invalid @enderror" name="actual_km">
                            @error('actual_km')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group d-flex">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>

                        </div>
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.trip.delete', $trip->id) }}" method="post" id="deleteForm">
                @csrf
                @method('DELETE')

            </form>
        </div><!-- end col-->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Trips</h4>

                    <form action="{{ route('admin.trip.update',Crypt::encrypt($trip->id)) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="">Select Car</label>
                            <select class="form-control @error('vehicule') is-invalid @enderror" data-toggle="select2" style="width: 100%" name="vehicule">
                                <option value="0">Select</option>
                                @foreach ($vehicules as $v)
                                    <option value="{{ $v->id }}" @selected($v->id == $trip->vehicule_id)>
                                        {{ $v->brand.' - '.$v->model.' - '.$v->matricule }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicule')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Select Driver</label>
                            <select class="form-control @error('driver') is-invalid @enderror" data-toggle="select2" style="width: 100%" name="driver">
                                <option value="0">Select</option>
                                @foreach ($drivers as $d)
                                    <option value="{{ $d->id }}" @selected($d->id == $trip->driver_id)>{{ $d->full_name. ' | '.$d->cin }}</option>
                                @endforeach
                            </select>
                            @error('driver')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="customCheck3" name="trip_type" @checked($trip->permanent)>
                                <label class="custom-control-label" for="customCheck3">Le Voyage permanent</label>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Date start</label>
                            <input type="date" class="form-control date @error('start_date') is-invalid @enderror" name="start_date" value="{{ $trip->start }}">
                            @error('start_date')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Date End</label>
                            <input type="date" class="form-control date @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{ $trip->end }}" @disabled($trip->permanent)>
                            @error('end_date')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group d-flex">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light ml-2" onclick="deleteTrip()">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.trip.delete', $trip->id) }}" method="post" id="deleteForm">
                @csrf
                @method('DELETE')

            </form>
        </div><!-- end col-->
        <script src="{{ asset('assets/js/trip/trip.js') }}"></script>
    </div>
    <script>
        function deleteTrip()
        {
            if(confirm('appuiye Ok pour suprime') == true)
            {
                document.getElementById("deleteForm").submit();
            }
        }
    </script>
</x-admin.app>
