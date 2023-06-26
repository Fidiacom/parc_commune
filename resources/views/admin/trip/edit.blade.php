<x-admin.app>
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- end col-->
    </div>
</x-admin.app>
