<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Nyi Nyi">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/active_fav.png') }}">
    <!-- Site Title -->
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('invoice-assets/css/style.css') }}">
</head>

<body>
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style1" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_align_center tm_mb20">
                        <div class="tm_invoice_left">
                            <div class="tm_logo"><img src="{{ URL::asset('assets/images/kmd_logo.png') }}"
                                    alt="Logo"></div>
                        </div>
                        <div class="tm_invoice_right tm_text_right">
                            <div class="tm_primary_color tm_f50 tm_text_uppercase">Invoice</div>
                        </div>
                    </div>
                    <div class="tm_invoice_info tm_mb20">
                        <div class="tm_invoice_seperator tm_gray_bg"></div>
                        <div class="tm_invoice_info_list">
                            <p class="tm_invoice_number tm_m0">Order No: <b
                                    class="tm_primary_color">#{{ $order->order_number }}</b></p>
                            <p class="tm_invoice_date tm_m0">Date: <b
                                    class="tm_primary_color">{{ date('d.m.Y', strtotime($order->date)) }}</b></p>
                        </div>
                    </div>
                    <div class="tm_invoice_head tm_mb10">
                        <div class="tm_invoice_left">
                            <p class="tm_mb2"><b class="tm_primary_color">Invoice From:</b></p>
                            <p>
                                Active Myanmar Store <br>
                                366-0011, Saitama Fukaya Ishizuka 933-1,<br>Japan<br>
                                paingsoethu1505@gmail.com
                            </p>
                        </div>
                        <div class="tm_invoice_right tm_text_right">
                            <p class="tm_mb2"><b class="tm_primary_color">Customer Info:</b></p>
                            <p>
                                {{ $order->receiver_name }}<br>
                                {{ $order->address }}<br>
                                {{ $order->receiver_phone }}<br>
                                {{ $order->state?$order->state->name:"-" }}, {{ $order->township?$order->township->name:"-" }}
                            </p>
                        </div>
                    </div>
                    <div class="tm_table tm_style1">
                        <div class="tm_round_border tm_radius_0">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tm_width_3 tm_semi_bold tm_primary_color tm_gray_bg">Item</th>
                                            <th class="tm_width_4 tm_semi_bold tm_primary_color tm_gray_bg">Description
                                            </th>
                                            <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg">Price</th>
                                            <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg">Qty</th>
                                            <th
                                                class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg tm_text_right">
                                                Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->order_detail as $detail)
                                        @php
                                            $firstImage = $detail->product->productImage->first();
                                        @endphp
                                            <tr class="tm_table_baseline">
                                                <td class="tm_width_3 tm_primary_color">
                                                  <img src="{{optional($firstImage)->image}}" alt="" width="70px" height="70px">
                                                </td>
                                                <td class="tm_width_4">{{$detail->product->name}}</td>
                                                <td class="tm_width_2">¥ {{$detail->unit_price}}</td>
                                                <td class="tm_width_1">{{$detail->quantity}}</td>
                                                <td class="tm_width_2 tm_text_right">¥ {{$detail->quantity * $detail->unit_price}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer tm_border_left tm_border_left_none_md">
                            <div class="tm_left_footer tm_padd_left_15_md">
                                <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                                <p class="tm_m0">
                                    {{ $order->payment_method ? $order->payment_method->name : 'Cash On Delivery' }}<br>Amount:
                                    ${{ $order->total_amount }}</p>
                            </div>
                            <div class="tm_right_footer">
                                <table>
                                    <tbody>
                                        <tr class="tm_gray_bg tm_border_top tm_border_left tm_border_right">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtoal</td>
                                            <td
                                                class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                                                ¥ {{$order->total_amount}}</td>
                                        </tr>
                                        <tr class="tm_gray_bg tm_border_left tm_border_right">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Discount <span
                                                    class="tm_ternary_color">(10%)</span></td>
                                            <td class="tm_width_3 tm_text_right tm_border_none tm_pt0 tm_danger_color">
                                                0</td>
                                        </tr>
                                        <tr class="tm_gray_bg tm_border_left tm_border_right">
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Tax <span
                                                    class="tm_ternary_color">(5%)</span></td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                                                0</td>
                                        </tr>
                                        <tr class="tm_border_top tm_gray_bg tm_border_left tm_border_right">
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color">Grand
                                                Total </td>
                                            <td
                                                class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right">
                                                ¥ {{$order->total_amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="tm_mb20">
                    <div class="tm_text_center">
                        <p class="tm_mb5"><b class="tm_primary_color">မှတ်ချက်:</b></p>
                        <p class="tm_m0">ဝယ်ယူအားပေးမှုကိုကျေးဇူးအများကြီးတင်ပါတယ်<br class="tm_hide_print">ပစ္စည် တစုံတရာအဆင်မပြေမှုရှိပါကာ pageကနေ ဆက်သွယ် ပြောဆိုနိုင်ပါတယ်။</p>
                    </div><!-- .tm_note -->
                </div>
            </div>

        </div>
    </div>
    <script src="{{ asset('invoice-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('invoice-assets/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('invoice-assets/js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('invoice-assets/js/main.js') }}"></script>
    <script>
       window.print();
        window.onafterprint = function() {
            window.location.href = "{{ route('orders') }}";
        };
    </script>
</body>

</html>
