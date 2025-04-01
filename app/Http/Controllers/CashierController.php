<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Order;
use Illuminate\Http\Request;
use Str;
use Hash;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashiers = Cashier::orderbydesc('id')->get();
        return view('cashier/list',['cashiers' => $cashiers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashier/create');
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
            'phone' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        if($fields['password'] != $fields['confirm_password']){
            return redirect()->back()->withInput()->with('error','Confirm Password does not match!');
        }
        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/cashier';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            $cashier = Cashier::create(
                [
                    'name' => $fields['name'],
                    'phone' => $fields['phone'],
                    'email' => $request->email,
                    'image' => asset("img/cashier/$image"),
                    'password' => Hash::make($fields['password']),
                ]
            );
        } else {
            $cashier = Cashier::create(
                [
                    'name' => $fields['name'],
                    'phone' => $fields['phone'],
                    'email' => $request->email,
                    'password' => Hash::make($fields['password']),
                ]
            );
        }
        return redirect()->route('cashiers')->with('success', "Successfully Created Cashier!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function show(Cashier $cashier)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cashier = Cashier::find($id);
        if($cashier){
            return view('cashier/edit',['cashier' => $cashier]);
        }
        else{
            return redirect()->route('cashiers')->with('error', "Cashier cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashier $cashier)
    {
        $fields = $request->validate([
          'name' => 'required',
          'phone' => 'required',
          'id' => 'required',
        ]);

        if(isset($request->password)){
            if($request->password != $request->confirm_password){
                return redirect()->back()->withInput()->with('error','Confirm Password does not match!');
            }
        }
        $cashier = Cashier::find($request->id);

        if ($request->file('image')) {
            $photo = $request->file('image');
            $destinationPath = 'img/cashier';
            $image = Str::random(12) . "." . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image);

            if(isset($request->password)){
                $cashier->update(
                    [
                       'name' => $fields['name'],
                        'phone' => $fields['phone'],
                        'email' => $request->email,
                        'image' => asset("img/cashier/$image"),
                        'password' => Hash::make($request->password),
                    ]
                );
            }
            else{
                $cashier->update(
                    [
                       'name' => $fields['name'],
                        'phone' => $fields['phone'],
                        'email' => $request->email,
                        'image' => asset("img/cashier/$image"),
                    ]
                );
            }
            
        } else {
            if(isset($request->password)){
                $cashier->update(
                    [
                        'name' => $fields['name'],
                        'phone' => $fields['phone'],
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]
                );
            }
            else{
                $cashier->update(
                    [
                        'name' => $fields['name'],
                        'phone' => $fields['phone'],
                        'email' => $request->email,
                    ]
                );
            }
            
        }

        return redirect()->route('cashiers')->with('success', "Successfully Updated Cashier!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cashier  $cashier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $cashier = Cashier::find($fields['delete_id']);
        if($cashier){
            $count = Order::where('cashier_id',$cashier->id)->count();
            if($count == 0){
                $cashier->delete();
                return redirect()->route('cashiers')->with('success', "Successfully Deleted Cashier!");
            }
            else{
                return redirect()->route('cashiers')->with('error', "Please Delete Order First!");
            }
        }
        else{
            return redirect()->route('cashiers')->with('error', "Cashier cannot be found!");
        }
    }
}
