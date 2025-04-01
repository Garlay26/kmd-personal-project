@extends('layouts.master')
@section('title')
   Edit Admin
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Admins
        @endslot
        @slot('title')
            Edit Admin
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('admin-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <input type="hidden" value="{{$admin->id}}" required name="id">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input class="form-control" type="text" value="{{$admin->name}}" id="example-text-input"
                                            name="adminName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Email</label>
                                        <input class="form-control" type="text" value="{{$admin->email}}" id="example-text-input"
                                            name="adminEmail" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Phone</label>
                                        <input class="form-control" type="number" value="{{$admin->phone}}" id="example-text-input"
                                            name="adminPhone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Password</label>
                                        <input class="form-control" type="text" id="example-text-input"
                                            name="adminPassword">
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
    <!-- End Form Layout -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
