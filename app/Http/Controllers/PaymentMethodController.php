<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Order;
use Illuminate\Http\Request;
use Str;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderbydesc('id')->get();
        return view('payment-method/list',['paymentMethods' => $paymentMethods]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment-method/create');
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
            'name' => 'required',
        ]);

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/payment-method';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $paymentMethod = PaymentMethod::create(
                [
                    'name' => $fields['name'],
                    'image' => asset("img/payment-method/$image"),
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                ]
            );
        } else {
            $paymentMethod = PaymentMethod::create(
                [
                    'name' => $fields['name'],
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                ]
            );
        }
        return redirect()->route('payment-methods')->with('success', "Successfully Created PaymentMethod!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::find($id);
        if($paymentMethod){
            return view('payment-method/edit',['paymentMethod' => $paymentMethod]);
        }
        else{
            return redirect()->route('payment-methods')->with('error', "Payment Method cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\paymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'id' => 'required',
        ]);

        $paymentMethod = PaymentMethod::find($fields['id']);
        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/payment-method';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $paymentMethod->update(
                [
                    'name' => $fields['name'],
                    'image' => asset("img/payment-method/$image"),
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                ]
            );
        } else {
            $paymentMethod->update(
                [
                    'name' => $fields['name'],
                    'account_name' => $request->account_name,
                    'account_number' => $request->account_number,
                ]
            );
        }
        return redirect()->route('payment-methods')->with('success', "Successfully Updated PaymentMethod!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $paymentMethod = PaymentMethod::find($fields['delete_id']);
        if($paymentMethod){
            $count = Order::where('payment_method_id',$paymentMethod->id)->count();
            if($count == 0){
                $paymentMethod->delete();
                return redirect()->route('payment-methods')->with('success', "Successfully Deleted Payment Method!");
            }
            else{
                return redirect()->route('payment-methods')->with('error', "Please Delete Order First!");
            }
        }
        else{
            return redirect()->route('payment-methods')->with('error', "Payment Method cannot be found!");
        }
    }
}
