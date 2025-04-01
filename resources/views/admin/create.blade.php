@extends('layouts.master')
@section('title')
   Add New Banner
@endsection
@section('css')
<style>
    #imagePreview img {
        max-width: 100px;
        margin-top: 10px;
        /* Adjust this value to set the desired margin */
    }
</style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
        Admin
        @endslot
        @slot('title')
            Add New Admin
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('admin-store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="adminName">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Email</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="adminEmail">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Phone</label>
                                        <input class="form-control" type="number" value="" id="example-text-input"
                                            name="adminPhone">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Password</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="adminPassword">
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
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
