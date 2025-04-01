@extends('layouts.master')
@section('title')
   Add New Cashier
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Cashiers
        @endslot
        @slot('title')
            Add New Cashier
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('cashier-store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input class="form-control" type="text" value="{{ old('name') }}" id="example-text-input"
                                            name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Phone Number</label>
                                        <input class="form-control" type="text" value="{{ old('phone') }}" id="example-text-input"
                                            name="phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Email</label>
                                        <input class="form-control" type="email" value="{{ old('email') }}" id="example-text-input"
                                            name="email" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Password</label>
                                        <input class="form-control" type="password" value="{{ old('password') }}" id="example-text-input"
                                            name="password" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Confirm Password</label>
                                        <input class="form-control" type="password" value="{{ old('confirm_password') }}" id="example-text-input"
                                            name="confirm_password" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Image</label>
                                        <input class="form-control" type="file" value="" id="example-text-input"
                                            name="image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6"></div>
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
