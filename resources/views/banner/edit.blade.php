@extends('layouts.master')
@section('title')
   Edit Banner
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
        Banners
        @endslot
        @slot('title')
            Edit Banner
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{route('banner-update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Link</label>
                                        <input class="form-control" type="text" value="" id="example-text-input"
                                            name="link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Banner Image</label>
                                        <input class="form-control" type="file" value="" id="fileInput"
                                            name="image">
                                            <div id="imagePreview">
                                                <img src="{{ $banner->image }}" alt="">
                                            </div>
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
@endsection
