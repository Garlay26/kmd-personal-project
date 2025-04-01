<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTime;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliverytimes = DeliveryTime::orderbydesc('id')->get();
        return view('delivery-time/list', ['deliverytimes' => $deliverytimes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('delivery-time/create');
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
            'time' => 'required',
        ]);
        $check = DeliveryTime::where('time',$fields['time'])->first();
        if(!$check){
            $deliverytime = DeliveryTime::create(
                [
                    'time' => $fields['time'],
                ]
            );
            return redirect()->route('deliverytimes')->with('success', "Successfully Created DeliveryTime!");
        }
        else{
            return redirect()->route('deliverytimes')->with('error', "DeliveryTime name is already taken!");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryTime  $deliverytime
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryTime $deliverytime)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryTime  $deliverytime
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deliverytime = DeliveryTime::find($id);
        if ($deliverytime) {
            return view('delivery-time/edit', ['deliverytime' => $deliverytime]);
        } else {
            return redirect()->route('deliverytimes')->with('error', "DeliveryTime cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryTime  $deliverytime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryTime $deliverytime)
    {
        $fields = $request->validate([
            'time' => 'required',
            'id' => 'required',
        ]);
        $deliverytime = DeliveryTime::find($request->id);

        $deliverytime->update(
            [
                'time' => $fields['time'],
            ]
        );

        return redirect()->route('deliverytimes')->with('success', "Successfully Updated DeliveryTime!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryTime  $deliverytime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $deliverytime = DeliveryTime::find($fields['delete_id']);
        if ($deliverytime) {
            $count = Order::where('delivery_time_id', $deliverytime->id)->count();
            if ($count == 0) {
                $deliverytime->delete();
                return redirect()->route('deliverytimes')->with('success', "Successfully Deleted DeliveryTime!");
            } else {
                return redirect()->route('deliverytimes')->with('error', "Please Delete Order First!");
            }
        } else {
            return redirect()->route('deliverytimes')->with('error', "DeliveryTime cannot be found!");
        }
    }
}
