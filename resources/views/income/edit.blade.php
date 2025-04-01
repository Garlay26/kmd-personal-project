@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    Edit Income
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Incomes
        @endslot
        @slot('title')
            Edit Income
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{ route('income-update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Title</label>
                                        <input class="form-control" type="text" id="example-text-input"
                                            name="title" required value="{{$income->title}}">
                                            <input type="hidden" name="id" value="{{$income->id}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="datepicker-basic" class="form-label">Date</label>
                                        <input type="text" class="form-control" id="datepicker-basic" name="date" required value="{{$income->date}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Amount</label>
                                        <input class="form-control" type="number" id="example-text-input"
                                            name="amount" required value="{{$income->amount}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Remark</label>
                                        <textarea name="remark" id="" cols="30" rows="10" class="form-control">{{$income->remark}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
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

    @include('layouts.error-fix')
@endsection
@section('script')
    {{-- <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
