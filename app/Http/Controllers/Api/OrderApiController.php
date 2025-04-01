<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Str;
use Validator;

class OrderApiController extends Controller
{
    public function orderList(Request $request)
    {
        $customer = getAuth($request);
        $cacheName = "order_" . "$customer->id" . "page_id" . "$request->page";
        if (Cache::has($cacheName)) {
            $orders = Cache::get($cacheName);
            return apiResponse(true, 'Order List Fetch From Cache', $orders, 200);
        } else {
            $orders = Order::where('customer_id', $customer->id)
                ->select('id', 'order_number', 'status', 'total_amount', 'date')
                ->orderbydesc('id')
                ->paginate(10);
            Cache::forever($cacheName, $orders);
            return apiResponse(true, 'Order List Fetch From Database', $orders, 200);
        }

    }

    public function orderDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        };

        $order = Order::where('id', $request->order_id)->with('country', 'state', 'township', 'deliveryTime', 'customer', 'payment_method', 'order_detail.product.productImage', 'order_detail.product.brand', 'order_detail.product.category')->first();
        if ($order) {
            return apiResponse(true, 'Order Detail Fetch', $order, 200);
        } else {
            return apiResponse(false, 'Wrong Order ID!', [], 400);
        }
    }

    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'state_id' => 'required',
            'township_id' => 'required',
            'delivery_time_id' => 'required',
            'address' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'note' => 'required',
            'total_amount' => 'required',
            'product' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Please Fill Required Information!', $validator, 400);
        };

        try {
            \DB::beginTransaction();
            if ($request->file('payment_image')) {
                $photo = $request->file('payment_image');
                $destinationPath = 'img/payment_image';
                $image = Str::random(13) . "." . $photo->getClientOriginalExtension();
                $photo->move($destinationPath, $image);

                $payment_image = asset("img/payment_image/$image");
            }

            $payment_image = $payment_image ?? null;
            $customer = getAuth($request);
            $order_number = Str::random(5);
            $products = $request->product;

            $order = Order::create([
                'order_number' => $order_number,
                'customer_id' => $customer->id,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'township_id' => $request->township_id,
                'delivery_time_id' => $request->delivery_time_id,
                'address' => $request->address,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'note' => $request->note,
                'total_amount' => $request->total_amount,
                'payment_method_id' => $request->payment_method_id,
                'payment_image' => $payment_image,
                'date' => date('Y-m-d H:i:s'),
            ]);

            foreach ($products as $product) {
                $productObject = Product::find($product['product_id']);

                if ($productObject->quantity < $product['qty']) {
                    \DB::rollback();
                    return apiResponse(false, 'Not Enough Quantity', [], 400);
                }

                $productObject->quantity = $productObject->quantity - $product['qty'];
                $productObject->save();

                $order_detail = OrderDetail::create([
                    'product_id' => $product['product_id'],
                    'customer_id' => $customer->id,
                    'order_id' => $order->id,
                    'quantity' => $product['qty'],
                    'unit_price' => $productObject->price,
                    'date' => date('Y-m-d'),
                ]);
            }

            $customer_id = $customer->id;
            $title = "Your Order is successfully placed";
            $message = " ";
            $type = 'order';
            $type_id = $order->id;
            sendNoti($customer_id, $title, $message, $type, $type_id);

            \DB::commit();
            return apiResponse(true, 'Order Created Successfully', $order, 200);
        } catch (\Throwable $th) {
            \DB::rollback();
            dd($th);
            return apiResponse(false, 'Order Create Fail', $th, 500);
        }
    }
}
