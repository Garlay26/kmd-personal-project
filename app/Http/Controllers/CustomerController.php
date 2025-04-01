<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderbydesc('id')->get();
        return view('customer/list',['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if($customer){
            return view('customer/detail',['customer' => $customer]);
        }
        else{
            return redirect()->route('customers')->with('error', "Customer cannot be found!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function ban(Request $request){
        $fields = $request->validate([
            'ban_id' => 'required',
        ]);
        $customer = Customer::find($request->ban_id);
        if($customer){
            $customer->update(['status' => 'ban']);
            return redirect()->route('customers')->with('success', "Successfully Ban Customer!");
        }
        else{
            return redirect()->route('customers')->with('error', "Customer cannot be found!");
        }
    }

    public function unban(Request $request){
        $fields = $request->validate([
            'unban_id' => 'required',
        ]);
        $customer = Customer::find($request->unban_id);
        if($customer){
            $customer->update(['status' => 'active']);
            return redirect()->route('customers')->with('success', "Successfully UnBan Customer!");
        }
        else{
            return redirect()->route('customers')->with('error', "Customer cannot be found!");
        }
    }
}
