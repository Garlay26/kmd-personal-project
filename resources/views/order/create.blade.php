@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/libs/choices.js/choices.js.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    Add New Order
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Orders
        @endslot
        @slot('title')
            Add New Order
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body p-4">

                    <form action="{{ route('order-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Customer</label>
                                        <input class="form-control" type="text" value="Walk In Customer"
                                            id="example-text-input" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label for="datepicker-basic" class="form-label">Date</label>
                                        <input type="text" class="form-control" id="datepicker-basic" name="date"
                                            required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <div class="mb-3">
                                        <label for="choices-single-default"
                                            class="form-label font-size-13 text-muted">Product</label>
                                        <select class="form-control" data-trigger name="" id="choices-single-default"
                                            placeholder="Select Category">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0 table-nowrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Product Desc</th>
                                                        <th>Price</th>
                                                        <th>Order Qty</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="appendProduct">
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <button class="btn btn-success" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="total_amount" value="0">
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    @include('layouts.error-fix')
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/choices.js/choices.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/@simonwep/@simonwep.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-cart.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        function load_js(srcUrl) {
            var head = document.getElementsByTagName('head')[0];
            var script = document.createElement('script');
            script.src = srcUrl;
            head.appendChild(script);
        }
    </script>
    <script>
        $(document).ready(function() {
            var productArray = []; // Declare productArray once, outside the event handler

            $('#choices-single-default').change(function() {
                var product_id = $(this).val();
                var total_amount = $('input[name=total_amount]').val();
                $.ajax({
                    url: `/product/detail/${product_id}`, // Replace {id} with the actual product ID or use a variable if dynamic
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var final_amount = parseInt(total_amount) + parseInt(response.price);
                        $('input[name=total_amount]').val(final_amount);
                        var appendDiv = $('#appendProduct');
                        appendDiv.append(
                            `<tr>
                                <td>
                                    <img src="${response.image}" alt="product-img"
                                        title="product-img" class="avatar-md" />
                                </td>
                                <td>
                                    <h5 class="font-size-14 text-truncate"><a
                                            href=""
                                            class="text-dark">${response.name}</a>
                                    </h5>
                                    <p class="mb-0">Weight : <span
                                            class="fw-medium">${response.weight}</span>
                                    </p>
                                </td>
                                <td>
                                    ¥ ${response.price}
                                </td>
                                <td>
                                    <div class="me-3" style="width: 60px;">
                                        <input type="hidden" value="${response.id}" name="product_${response.id}">
                                         <input type="hidden" value="${response.price}" name="price_${response.id}">
                                        <input type="text" value="1" class="demo_vertical" id="${response.id}"
                                            name="quantity_${response.id}" readonly>
                                    </div>
                                </td>
                                <td id="total_${response.id}">
                                    ¥ ${response.price}
                                </td>
                            </tr>`);
                            load_js("{{ asset('assets/js/pages/ecommerce-cart.init.js') }}");
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });

            });
        });

        $(document).on('change', 'input.demo_vertical', function() {
            var final_amount = 0;
            $('input.demo_vertical').each(function() {
                var id = $(this).attr('id');
                var quantity = $(`input[name=quantity_${id}]`).val();
                var price = $(`input[name=price_${id}]`).val();
                var unit_price = parseInt(quantity) * parseInt(price);
                console.log(unit_price);
                final_amount += parseInt(unit_price);
            });

            $('input[name=total_amount]').val(final_amount);
            
        });
    </script>
@endsection
