@extends('layouts.master')
@section('title')
    @lang('translation.Dashboards')
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/admin-resources/admin-resources.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Welcome !
        @endslot
    @endcomponent
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <a href="{{route('orders')}}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Approved Orders</span>
                                <h4 class="mb-3">
                                    {{ $total_orders }}
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </a>
            </div><!-- end card -->
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <a href="{{route('orders')}}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Pending Orders</span>
                                <h4 class="mb-3">
                                    {{ $total_pending_orders }}
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </a>
            </div><!-- end card -->
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
           <a href="{{route('orders')}}">
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Sales</span>
                            <h4 class="mb-3">
                                {{ $total_sales }}
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
           </a>
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <a href="{{ route('customers') }}">
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Customers</span>
                                <h4 class="mb-3">
                                    {{ $total_customers }}
                                </h4>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </a>
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <a href="{{ route('products') }}">
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Products</span>
                                <h4 class="mb-3">
                                    {{ $total_products }}
                                </h4>
                            </div>

                          
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </a>
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <a href="{{ route('brands') }}">
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Brands</span>
                                <h4 class="mb-3">
                                    {{ $total_brands }}
                                </h4>
                            </div>

                          
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </a>
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <a href="{{ route('categories') }}">
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Categories</span>
                                <h4 class="mb-3">
                                    {{ $total_categories }}
                                </h4>
                            </div>

                          
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </a>
        </div>
        <div class="col-xl-3 col-md-3">
            <!-- card -->
            <a href="{{ route('admins') }}">
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Admins</span>
                                <h4 class="mb-3">
                                    {{ $total_admins }}
                                </h4>
                            </div>

                          
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </a>
        </div>
    </div>

    @include('layouts.error-fix')
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/admin-resources/admin-resources.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
