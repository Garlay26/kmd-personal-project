<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::orderbydesc('id')->get();
        return view('country/list', ['countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('country/create');
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
        $check = Country::where('name',$fields['name'])->first();
        if(!$check){
            $country = Country::create(
                [
                    'name' => $fields['name'],
                ]
            );
            return redirect()->route('countries')->with('success', "Successfully Created Country!");
        }
        else{
            return redirect()->route('countries')->with('error', "Country name is already taken!");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        if ($country) {
            return view('country/edit', ['country' => $country]);
        } else {
            return redirect()->route('countries')->with('error', "Country cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $fields = $request->validate([
            'name' => 'required',
            'id' => 'required',
        ]);
        $country = Country::find($request->id);

        $country->update(
            [
                'name' => $fields['name'],
            ]
        );

        return redirect()->route('countries')->with('success', "Successfully Updated Country!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $country = Country::find($fields['delete_id']);
        if ($country) {
            $count = State::where('country_id', $country->id)->count();
            if ($count == 0) {
                $country->delete();
                return redirect()->route('countries')->with('success', "Successfully Deleted Country!");
            } else {
                return redirect()->route('countries')->with('error', "Please Delete State First!");
            }
        } else {
            return redirect()->route('countries')->with('error', "Country cannot be found!");
        }
    }
}
