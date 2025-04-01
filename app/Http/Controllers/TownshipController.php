<?php

namespace App\Http\Controllers;

use App\Models\Township;
use App\Models\State;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $townships = Township::orderbydesc('id')->get();
        return view('township/list', ['townships' => $townships]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::orderbydesc('id')->get();
        return view('township/create',['states' => $states]);
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
            'state_id' => 'required',
        ]);
        $check = Township::where('name',$fields['name'])->where('state_id',$fields['state_id'])->first();
        if(!$check){
            $township = Township::create(
                [
                    'name' => $fields['name'],
                    'state_id' => $fields['state_id'],
                ]
            );
            return redirect()->route('township-create')->with('success', "Successfully Created Township!");
        }
        else{
            return redirect()->route('townships')->with('error', "Township name is already taken!");
        }
       
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function show(Township $township)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $township = Township::find($id);
        if ($township) {
            $states = State::orderbydesc('id')->get();
            return view('township/edit', ['township' => $township,'states' => $states]);
        } else {
            return redirect()->route('townships')->with('error', "Township cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Township $township)
    {
        $fields = $request->validate([
            'name' => 'required',
            'id' => 'required',
            'state_id' => 'required',
        ]);
        $township = Township::find($request->id);

        $township->update(
            [
                'name' => $fields['name'],
                'state_id' => $fields['state_id'],
            ]
        );

        return redirect()->route('townships')->with('success', "Successfully Updated Township!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Township  $township
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $township = Township::find($fields['delete_id']);
        if ($township) {
            $township->delete();
            return redirect()->route('townships')->with('success', "Successfully Deleted Township!");
        } else {
            return redirect()->route('townships')->with('error', "Township cannot be found!");
        }
    }
}
