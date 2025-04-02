<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::when(!empty($request->customer_id), function ($query) use ($request) {
            return $query->where('customer_id', $request->customer_id);
        })
            ->when(!empty($request->search), function ($query) use ($request) {
                $search = str_replace('#', '', $request->search);
                return $query->where('order_number', 'like', '%' . $search . '%');
            })
            ->where('status', 'approved')
            ->orderbydesc('id')
            ->paginate(20);
        $customers = Customer::select('id', 'name')->orderbydesc('id')->get();
        return view('order/list', ['orders' => $orders, 'customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderbydesc('id')->get();
        return view('order/create', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'date' => 'required',
            'name' => 'required',
            'total_amount' => 'required',
        ]);

        try {
            \DB::beginTransaction();
            $order_number = Str::random(5);
            $order = Order::create([
                'order_number' => $order_number,
                'date' => $fields['date'],
                'customer_id' => 9999999,
                'country_id' => 9999999,
                'state_id' => 9999999,
                'township_id' => 9999999,
                'delivery_time_id' => 9999999,
                'receiver_name' => $fields['name'],
                'total_amount' => $fields['total_amount'],
                'status' => 'Approved',
                'cashier_id' => \Auth::user()->id,
            ]);
            $allInputs = $request->all();

            // Filter inputs that start with 'product_'
            $productInputs = array_filter($allInputs, function ($key) {
                return strpos($key, 'product_') === 0;
            }, ARRAY_FILTER_USE_KEY);

            foreach ($productInputs as $product_id) {
                $productObject = Product::find($product_id);
                $string = "quantity_$product_id";
                $quantity = $request->$string;
                if ($productObject->quantity < $quantity) {
                    \DB::rollback();
                    return redirect()->route()->with('error','Not Enought Quantity');
                }

                $productObject->quantity = $productObject->quantity - $quantity;
                $productObject->save();

                $order_detail = OrderDetail::create([
                    'product_id' => $product_id,
                    'customer_id' => $order->customer_id,
                    'order_id' => $order->id,
                    'quantity' => $quantity,
                    'unit_price' => $productObject->price,
                    'date' => date('Y-m-d'),
                ]);
            }
            \DB::commit();
            return redirect()->route('order-print', ['order_id' => $order->id]);
        } catch (\Throwable $th) {
            \DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order/detail', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function cancel(Request $request)
    {
        $fields = $request->validate([
            'cancel_id' => 'required',
            'cancel_remark' => 'required',
        ]);

        try {
            \DB::beginTransaction();
            $order = Order::where('id', $fields['cancel_id'])->where('status', 'pending')->first();
            if ($order) {
                $order->status = 'cancel';
                $order->remark = $request->cancel_remark;
                $order->save();

                if ($order->save()) {
                    $order_details = OrderDetail::where('order_id', $order->id)->get();
                    foreach ($order_details as $order_detail) {
                        $product = Product::find($order_detail->product_id);
                        $product->quantity = $product->quantity + $order_detail->quantity;
                        $product->save();
                    }
                }

                $customer = Customer::find($order->customer_id);
                if ($customer->email) {
                    //Send Email to Customer

                }

                //Send Notti to Customer
                $customer_id = $customer->id;
                $title = "Your Order is canceled";
                $message = $request->cancel_remark;
                $type = 'order';
                $type_id = $order->id;
                sendNoti($customer_id, $title, $message, $type, $type_id);

                \DB::commit();
                return redirect()->route('orders')->with('success', "Order Cancel Successfully!");
            } else {
                \DB::rollback();
                return redirect()->route('orders')->with('error', "Something Went Wrong! Please Try Again Later");
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->route('orders')->with('error', "Something Went Wrong! Please Try Again Later");
        }

    }

    public function approve(Request $request)
    {
        // dd($request);
        $fields = $request->validate([
            'approve_id' => 'required',
            'approve_remark' => 'required',
        ]);
        try {
            \DB::beginTransaction();
            $order = Order::where('id', $fields['approve_id'])->where('status', 'pending')->first();
            if ($order) {
                $order->status = 'approved';
                $order->remark = $request->approve_remark;
                $order->save();

                $customer = Customer::find($order->customer_id);
                if ($customer) {
                    if ($customer->email) {
                        //Send Email to Customer

                    }

                    //Send Notti to Customer
                    $customer_id = $customer->id;
                    $title = "Your Order is approved";
                    $message = $request->approve_remark;
                    $type = 'order';
                    $type_id = $order->id;
                    sendNoti($customer_id, $title, $message, $type, $type_id);
                }

                \DB::commit();
                return redirect()->route('order-print', ['order_id' => $order->id]);
            } else {
                \DB::rollback();
                return redirect()->route('orders')->with('error', "Something Went Wrong! Please Try Again Later");
            }
        } catch (\Throwable $th) {
            \DB::rollback();
            // dd($th);
            return redirect()->route('orders')->with('error', "Something Went Wrong! Please Try Again Later");
        }

    }

    public function print(request $request)
    {
        $fields = $request->validate([
            'order_id' => 'required',
        ]);

        $order = Order::find($fields['order_id']);
        if (!$order) {
            return redirect()->route('orders')->with('error', "Something Went Wrong! Please Try Again Later");
        };

        return view('order/print', ['order' => $order]);
    }
}
