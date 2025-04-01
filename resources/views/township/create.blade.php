@extends('layouts.master')
@section('title')
    Add New Township
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            township-store
        @endslot
        @slot('title')
            Add New Township
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{ route('township-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Township</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="name" autofocus required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="choices-single-default"
                                            class="form-label font-size-13 text-muted">State</label>
                                        <select class="form-control" data-trigger name="state_id"
                                            id="choices-single-default" placeholder="Select Country" required>
                                            @php
                                                $last = App\Models\Township::orderbydesc('id')->first();
                                            @endphp
                                            @if ($last)
                                                @foreach ($states as $state)
                                                    @if ($state->id == $last->state_id)
                                                        <option value="{{ $state->id }}" selected>{{ $state->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
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
    <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
