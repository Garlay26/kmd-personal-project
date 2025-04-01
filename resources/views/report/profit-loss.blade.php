@extends('layouts.master')
@section('title')
    Profit Loss
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Report
        @endslot
        @slot('title')
            Profit Loss
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    {{-- <h4 class="card-title">Please Choose Data Range</h4> --}}
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-lg-3">
                                <div>
                                    <div class="mb-3">
                                        <label for="datepicker-basic" class="form-label">Start Date</label>
                                        <input type="text" class="form-control" id="datepicker-basic" name="start_date"
                                            required value="{{ $_REQUEST['start_date'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div>
                                    <div class="mb-3">
                                        <label for="datepicker-basic" class="form-label">End Date</label>
                                        <input type="text" class="form-control" id="datepicker-basic" name="end_date"
                                            required value="{{ $_REQUEST['end_date'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div>
                                    <div class="mb-3">
                                        <label for="datepicker-basic" class="form-label">&nbsp;</label><br>
                                        <button class="btn btn-success" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Income</th>
                                    <th>Outcome</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" style="color:green"><strong>Income</strong></td>
                                </tr>
                                @php
                                    $i = 0;
                                    $net = 0;
                                @endphp
                                @foreach ($incomes as $income)
                                    @php
                                        ++$i;
                                        $net += $income->amount;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{date('d/M/Y',strtotime($income->date))}}</td>
                                        <td>{{ $income->title }}</td>
                                        <td>{{ $income->amount }}</td>
                                        <td>0</td>
                                    </tr>
                                @endforeach

                                {{-- Outcome --}}
                                <tr>
                                    <td colspan="4" style="color:green"><strong>Outcome</strong></td>
                                </tr>

                                @foreach ($outcomes as $outcome)
                                    @php
                                        ++$i;
                                        $net -= $outcome->amount;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{date('d/M/Y',strtotime($outcome->date))}}</td>
                                        <td>{{ $outcome->title }}</td>
                                        <td>0</td>
                                        <td>{{ $outcome->amount }}</td>
                                    </tr>
                                @endforeach

                                {{-- Sale --}}
                                <tr>
                                    <td colspan="4" style="color:green"><strong>Sale</strong></td>
                                </tr>

                                @foreach ($orders as $order)
                                    @php
                                        ++$i;
                                        $net += $order->total_amount;
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>{{date('d/M/Y',strtotime($order->date))}}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->total_amount }}</td>
                                        <td>0</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    @if ($net >= 0)
                                        <td style="color:blue">Total Amount</td>
                                        <td colspan="3" style="color:blue"><strong>{{ $net }}</strong></td>
                                    @else
                                        <td style="color:red">Total Amount</td>
                                        <td colspan="3" style="color:red"><strong>{{ $net }}</strong></td>
                                    @endif

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
    @include('layouts.error-fix')
@endsection
@section('script')
    {{-- <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
