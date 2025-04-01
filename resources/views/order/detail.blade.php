@extends('layouts.master')
@section('title')
    Order Detail
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Orders
        @endslot
        @slot('title')
            Order Detail #{{ $order->order_number }}
        @endslot
    @endcomponent
    @php
        $order_details = $order->order_detail;
    @endphp
    <div class="row">
        <div class="col-xl-8">
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
                                    <th>Scan Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order_details as $order_detail)
                                    @php
                                        $firstImage = $order_detail->product->productImage->first();
                                    @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ optional($firstImage)->image }}" alt="product-img"
                                                title="product-img" class="avatar-md" />
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 text-truncate"><a
                                                    href="{{ route('product-edit', ['id' => $order_detail->product_id]) }}"
                                                    class="text-dark">{{ $order_detail->product->name }}</a></h5>
                                            <p class="mb-0">Weight : <span
                                                    class="fw-medium">{{ $order_detail->product->weight }}</span></p>
                                        </td>
                                        <td>
                                            ¥ {{ $order_detail->unit_price }}
                                        </td>
                                        <td>
                                            <div class="me-3" style="width: 60px;">
                                                <input type="text" value="{{ $order_detail->quantity }}"
                                                    class="demo_vertical" name="demo_vertical" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="me-3" style="width: 60px;">
                                                <input type="text" class="demo_vertical" value="0"
                                                    name="demo_vertical" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            ¥ {{ $order_detail->unit_price * $order_detail->quantity }}
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                    @if ($order->status == 'pending')
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-danger orderCancel" id="{{ $order->id }}"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal">
                                    <i class="mdi mdi-block-helper me-1"></i> Cancel </a>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <a href="#" class="btn btn-success orderApprove" id="{{ $order->id }}"
                                        data-bs-toggle="modal" data-bs-target="#approveModal">
                                        <i class="mdi mdi-cart-arrow-right me-1"></i> Approve </a>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Payment Method -
                        {{ $order->payment_method ? $order->payment_method->name : 'Cash On Delivery' }}</h5>
                    <div class="card">
                        <div class="card-body">
                            @if ($order->payment_image != null)
                                <a href="{{ $order->payment_image }}" target="_blank">
                                    <img src="{{ $order->payment_image }}" alt="" width="60%" height="auto">
                                </a>
                            @else
                                <p>No Payment Screenshot Exists</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Order Summary</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Grand Total :</td>
                                    <td>¥ {{ number_format($order->total_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Discount : </td>
                                    <td>¥ {{ number_format($order->discount_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Charge :</td>
                                    <td>¥ 0</td>
                                </tr>
                                <tr>
                                    <td>Tax : </td>
                                    <td>¥ 0</td>
                                </tr>
                                <tr>
                                    <td>Note :</td>
                                    <td>{{ $order->note }}</td>
                                </tr>
                                <tr>
                                    <td>Receiver Phone :</td>
                                    <td>{{ $order->receiver_phone }}</td>
                                </tr>
                                <tr>
                                    <td>Address :</td>
                                    <td>{{ $order->address }}</td>
                                </tr>
                                <tr>
                                    <td>Delivery Time :</td>
                                    <td>{{ $order->deliveryTime->time }}</td>
                                </tr>
                                <tr>
                                    <td>Remark :</td>
                                    <td>{{ $order->remark }}</td>
                                </tr>
                                <tr>
                                    <th>Total :</th>
                                    <th>¥ {{ number_format($order->total_amount) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
    <!-- end row -->
    <div id="cancelModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Are you sure to cancel this order?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('order-cancel') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="remark">Remark</label>
                                <textarea name="cancel_remark" id="remark" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cancel_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Cancel</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="approveModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Are you sure to approve this order?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('order-approve') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="remark">Remark</label>
                                <textarea name="approve_remark" id="remark" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="approve_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Approve</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-cart.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $("body").delegate(".orderCancel", "click", function() {
            var id = this.id;
            $('input[name=cancel_id]').val(id);
        });

        $("body").delegate(".orderApprove", "click", function() {
            var id = this.id;
            $('input[name=approve_id]').val(id);
        });
    </script>
@endsection
