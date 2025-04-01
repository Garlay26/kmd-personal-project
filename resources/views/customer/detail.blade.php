@extends('layouts.master')
@section('title')
    Customer Detail
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Customers
        @endslot
        @slot('title')
            Customer Detail
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a class="text-muted dropdown-toggle font-size-16" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Remove</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="{{ $customer->profile_image }}" alt=""
                                class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <div class="flex-1 ms-3">
                            <h5 class="font-size-15 mb-1"><a href="#" class="text-dark">{{ $customer->name }}</a></h5>
                            <p class="text-muted mb-0">Total Order - 0</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-1">
                        <p class="text-muted mb-0"><i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                            {{ $customer->phone }}</p>
                        <p class="text-muted mb-0 mt-2"><i
                                class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                            {{ $customer->email }}</p>
                        <p class="text-muted mb-0 mt-2"><i
                                class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                            {{ $customer->address }}</p>
                        <p class="text-muted mb-0 mt-2"><i
                                class="mdi mdi-calendar font-size-15 align-middle pe-2 text-primary"></i>
                            {{ date('d/M/Y', strtotime($customer->register_date)) }}</p>
                        <p class="text-muted mb-0 mt-2"><i
                                class="mdi mdi-emoticon-excited-outline font-size-15 align-middle pe-2 text-primary"></i>
                            {{ strtoupper($customer->status) }}</p>

                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->

    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
