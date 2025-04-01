@extends('layouts.master')
@section('title')
    @lang('translation.Orders')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Orders
        @endslot
        @slot('title')
            Order List
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row mb-2">
                            <div class="col-sm-3">
                                <div class="search-box me-2 mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Search..." name="search" value="@if(isset($_REQUEST['search'])) {{$_REQUEST['search']}} @endif">
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div>

                                    <select class="form-control" data-trigger name="customer_id" id="choices-single-default"
                                        placeholder="Select Customer">
                                        <option value="" disabled selected>Choose Customer</option>
                                        @foreach ($customers as $customer)
                                            @if (isset($_REQUEST['customer_id']))
                                                @if ($customer->id == $_REQUEST['customer_id'])
                                                    <option value="{{ $customer->id }}" selected>{{ $customer->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endif
                                            @else
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div>
                                    <button class="btn btn-success" type="submit">Search</button>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div>
                                    <a href="{{ route('orders') }}">
                                        <button class="btn btn-warning" type="button">Reset</button>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th class="align-middle">Order ID</th>
                                    <th class="align-middle">Customer Name</th>
                                    <th class="align-middle">Date</th>
                                    <th class="align-middle">Total</th>
                                    <th class="align-middle">Order Status</th>
                                    <th class="align-middle">Payment Method</th>
                                    <th class="align-middle">View Details</th>
                                    <th class="align-middle">Print</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td><span class="text-body fw-bold">#{{ $order->order_number }}</span> </td>
                                        <td>{{ $order->customer ? $order->customer->name : ' - ' }}</td>
                                        <td>
                                            {{ date('d/M/Y', strtotime($order->date)) }}
                                        </td>
                                        <td>
                                            ¥ {{ $order->total_amount }}
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case('approved')
                                                    <span
                                                        class="badge badge-pill badge-soft-success font-size-12">{{ strtoupper($order->status) }}</span>
                                                @break

                                                @case('pending')
                                                    <span
                                                        class="badge badge-pill badge-soft-warning font-size-12">{{ strtoupper($order->status) }}</span>
                                                @break

                                                @case('cancel')
                                                    <span
                                                        class="badge badge-pill badge-soft-danger font-size-12">{{ strtoupper($order->status) }}</span>
                                                @break

                                                @case('refund')
                                                    <span
                                                        class="badge badge-pill badge-soft-info font-size-12">{{ strtoupper($order->status) }}</span>
                                                @break
                                            @endswitch

                                        </td>
                                        <td>
                                            <i
                                                class="fab fa-cc-mastercard me-1"></i>{{ $order->payment_method ? $order->payment_method->name : ' - ' }}
                                        </td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <a href="{{ route('order-detail', ['id' => $order->id]) }}">
                                                <button type="button" class="btn btn-primary btn-sm btn-rounded"
                                                    data-bs-toggle="modal">
                                                    View Details
                                                </button>
                                            </a>
                                        </td>
                                        @if ($order->status == 'approved')
                                            <td>
                                                <a href="{{ route('order-print', ['order_id' => $order->id]) }}">
                                                    <button type="button"
                                                        class="btn btn-soft-success waves-effect waves-light"><i
                                                            class="fas fa-print"></i></button>
                                                </a>
                                            </td>
                                        @endif

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links('layouts.paginate') }}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
