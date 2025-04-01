@extends('layouts.master')
@section('title')
   Edit Delivery Time
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
        Delivery Times
        @endslot
        @slot('title')
            Edit Delivery Time
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('delivery-time-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Delivery Time</label>
                                        <input type="hidden" name="id" id="" value="{{$deliverytime->id}}">
                                        <input class="form-control" type="text" value="{{$deliverytime->time}}" id="example-text-input"
                                            name="time" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <button class="btn btn-success" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    <!-- End Form Layout -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
