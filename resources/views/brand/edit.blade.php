@extends('layouts.master')
@section('title')
   Edit Brand
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Brands
        @endslot
        @slot('title')
            Edit Brand
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('brand-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Title</label>
                                        <input type="hidden" name="id" id="" value="{{$brand->id}}" required>
                                        <input class="form-control" type="text" value="{{$brand->title}}" id="example-text-input"
                                            name="title" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Logo <span style="color:red">(It will remove previous images)</span></label>
                                        <input class="form-control" type="file" value="" id="example-text-input"
                                            name="image">
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
