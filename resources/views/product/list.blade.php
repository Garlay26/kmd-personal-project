@extends('layouts.master')
@section('title')
    @lang('translation.Products')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/nouislider/nouislider.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/gridjs/gridjs.min.css">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Products
        @endslot
        @slot('title')
            Product List
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">

            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6">
                    <div class="mt-2">
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                    <form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                        <div class="search-box me-2">
                            <div class="position-relative">
                                <input type="text" class="form-control border-0" placeholder="Search..." name="search" value="@if(isset($_REQUEST['search'])) {{$_REQUEST['search']}} @endif">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-xl-2 col-sm-6">
                        <a href="{{route('product-edit',['id' => $product->id])}}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="product-img position-relative">
                                        @php
                                            $first_image = $product->productImage->first();
                                        @endphp
                                        <img src="{{optional($first_image)->image}}" alt="{{$product->name}}"
                                            class="img-fluid mx-auto d-block" width="120px" height="200px">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-4">
                                        <div>
                                            <h5 class="mb-3 text-truncate"><a href="javascript: void(0);"
                                                    class="text-dark">{{$product->name}}</a></h5>
                                            <h5 class="my-0"><b>¥ {{$product->price}}</b>
                                            </h5>
                                        </div>
                                        <div>
                                            <h5 class="mb-3 text-truncate"><a href="javascript: void(0);"
                                                    class="text-dark"></a></h5>
                                            <h5 class="my-0"><b>{{$product->quantity}}</b>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- end row -->
            {{$products->links('layouts.paginate')}}
            
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/wnumb/wnumb.min.js') }}"></script>
    <script src="assets/libs/gridjs/gridjs.js"></script>
    <script src="https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js"></script>


    <script src="{{ URL::asset('assets/js/pages/ecommerce-product-list.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
