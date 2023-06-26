<x-admin.app>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Trips</h4>

                    <button type="button" class="btn btn-primary waves-effect waves-light mb-3" data-toggle="modal"
                        data-target=".bd-example-modal-lg">Add new trip</button>

                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title h4" id="myLargeModalLabel">Large modal</h5>
                                    <button type="button" class="close waves-effect waves-light" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.trip.store') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Select Car</label>
                                            <select class="form-control" data-toggle="select2" style="width: 100%" name="vehicule">
                                                <option value="0">Select</option>
                                                @foreach ($vehicules as $v)
                                                    <option value="{{ $v->id }}">
                                                        {{ $v->brand.' - '.$v->model.' - '.$v->matricule }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="">Select Driver</label>
                                            <select class="form-control" data-toggle="select2" style="width: 100%" name="driver">
                                                <option>Select</option>
                                                @foreach ($drivers as $d)
                                                    <option value="{{ $d->id }}">{{ $d->full_name. ' | '.$d->cin }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="customCheck3" name="trip_type">
                                                <label class="custom-control-label" for="customCheck3">Le Voyage permanent</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Date start</label>
                                            <input type="text" class="form-control date" id="start_date" data-toggle="daterangepicker" data-single-date-picker="true" name="start_date">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Date End</label>
                                            <input type="text" class="form-control date" id="end_date" data-toggle="daterangepicker" data-single-date-picker="true" name="end_date">
                                        </div>


                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('Driver name') }}</th>
                                <th>{{ __('Car name') }}</th>
                                <th>{{ __('Car matricule') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('From - To') }}</th>
                                <th>{{ __('Actions') }}</th>
                                <th>{{ __('car matricule') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach (range(1,100) as $items)
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>01-02-2000 | 20-03-2022</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</x-admin.app>
