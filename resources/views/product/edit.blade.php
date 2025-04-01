@extends('layouts.master')
@section('title')
    Edit Product
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
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
            Product
        @endslot
        @slot('title')
            Edit Product
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="padding: 0.5rem !important">
                    <div style="float: right">
                        <span>
                            <a href="{{route('print-barcode',['id' => $product->id])}}" target="_blank">
                                <button type="button" class="btn btn-soft-success waves-effect waves-light"><i
                                    class="fas fa-print"></i></button>
                            </a>
                        </span>
                        <button type="button" class="btn btn-soft-danger waves-effect waves-light deleteProduct"
                            id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('product-update') }}" method="POST" enctype="multipart/form-data"
                        id="submitForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Name</label>
                                        <input type="hidden" name="id" value="{{ $product->id }}" required>
                                        <input class="form-control" type="text" value="{{ $product->name }}"
                                            id="example-text-input" placeholder="ကြက်သား" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Price (¥)</label>
                                        <input class="form-control" type="number" value="{{ $product->price }}"
                                            id="example-text-input" placeholder="250" name="price" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="choices-single-default"
                                            class="form-label font-size-13 text-muted">Category</label>
                                        <select class="form-control" data-trigger name="category_id"
                                            id="choices-single-default" placeholder="Select Category">
                                            @foreach ($categories as $category)
                                                @if ($category->id == $product->category_id)
                                                    <option value="{{ $category->id }}" selected>{{ $category->title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="choices-single-default"
                                            class="form-label font-size-13 text-muted">Brand</label>
                                        <select class="form-control" data-trigger name="brand_id"
                                            id="choices-single-default" placeholder="Select Brand">
                                            @foreach ($brands as $brand)
                                                @if ($brand->id == $product->brand_id)
                                                    <option value="{{ $brand->id }}" selected>{{ $brand->title }}</option>
                                                @else
                                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Weight</label>
                                        <input class="form-control" type="text" value="{{ $product->weight }}"
                                            id="example-text-input" placeholder="120 Kg" name="weight" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Quantity</label>
                                        <input class="form-control" type="number" value="{{ $product->quantity }}"
                                            id="example-text-input" placeholder="100" name="quantity" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Description</label>
                                        <textarea name="desc" id="" cols="30" rows="7" class="form-control">{{ $product->desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Product Images <span
                                                style="color:red">(It will remove previous images)</span></label>
                                        <input type="file" class="form-control" name="images[]" id="fileInput"
                                            multiple>
                                        <div id="imagePreview">
                                            @foreach ($product->productImage as $image)
                                                <img src="{{ $image->image }}" alt="">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <button class="btn btn-success">Update</button>
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
    <div id="deleteModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Are you sure to delete this product?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product-delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="delete_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Listen for change event on file input
            $('#fileInput').change(function() {
                // Clear previous previews
                $('#imagePreview').empty();

                // Loop through selected files
                for (var i = 0; i < this.files.length; i++) {
                    var file = this.files[i];

                    // Create a new FileReader instance
                    var reader = new FileReader();

                    // When the file is loaded, create a new image element and set its src to the result of the FileReader
                    reader.onload = function(event) {
                        var imgElement = document.createElement('img');
                        imgElement.src = event.target.result;
                        imgElement.style.maxWidth = '100px'; // Set maximum width for the preview
                        document.getElementById('imagePreview').appendChild(imgElement);
                    };

                    // Read the file as a data URL
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <script>
        $("body").delegate(".deleteProduct", "click", function() {
            var id = this.id;
            $('input[name=delete_id]').val(id);
        });
    </script>
@endsection
