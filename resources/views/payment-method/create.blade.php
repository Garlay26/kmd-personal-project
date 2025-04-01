@extends('layouts.master')
@section('title')
   Add New Payment Method
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Payment Methods
        @endslot
        @slot('title')
            Add New Payment Method
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('payment-method-store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Payment Name</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Logo</label>
                                        <input class="form-control" type="file" value="" id="example-text-input"
                                            name="image" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Account Name</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="account_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Account Number</label>
                                        <input class="form-control" type="number" value="" id="example-text-input"
                                            name="account_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <button class="btn btn-success" type="submit">Submit</button>
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
