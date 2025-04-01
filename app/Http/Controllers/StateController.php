<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cacheName = "stateList";
        if (Cache::has($cacheName)) {
            $states = Cache::get($cacheName);
        } else {
            $states = State::orderbydesc('id')->get();
            Cache::forever($cacheName, $states);
        }

        return view('state/list', ['states' => $states]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::orderbydesc('id')->get();
        return view('state/create', ['countries' => $countries]);
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
            'country_id' => 'required',
        ]);

        $check = State::where('name', $fields['name'])->first();
        if (!$check) {
            $state = State::create(
                [
                    'name' => $fields['name'],
                    'country_id' => $fields['country_id'],
                ]
            );
            return redirect()->route('states')->with('success', "Successfully Created State!");
        } else {
            return redirect()->route('states')->with('error', "State name is already taken!");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = State::find($id);
        if ($state) {
            $countries = Country::orderbydesc('id')->get();
            return view('state/edit', ['state' => $state, 'countries' => $countries]);
        } else {
            return redirect()->route('states')->with('error', "State cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $fields = $request->validate([
            'name' => 'required',
            'id' => 'required',
            'country_id' => 'required',
        ]);
        $state = State::find($request->id);

        $state->update(
            [
                'name' => $fields['name'],
                'country_id' => $fields['country_id'],
            ]
        );

        return redirect()->route('states')->with('success', "Successfully Updated State!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $state = State::find($fields['delete_id']);
        if ($state) {
            $count = Township::where('state_id', $state->id)->count();
            if ($count == 0) {
                $state->delete();
                return redirect()->route('states')->with('success', "Successfully Deleted State!");
            } else {
                return redirect()->route('states')->with('error', "Please Delete Township First!");
            }
        } else {
            return redirect()->route('states')->with('error', "State cannot be found!");
        }
    }
}
