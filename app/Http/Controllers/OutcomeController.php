<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outcomes = Outcome::select('id', 'title', 'date', 'amount', 'remark')->orderbydesc('id')->get();
        return view('outcome/list', ['outcomes' => $outcomes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outcome/create');
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
            'title' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $outcome = Outcome::create([
            'title' => $fields['title'],
            'date' => date('Y-m-d', strtotime($fields['date'])),
            'amount' => $fields['amount'],
            'remark' => $request->remark,
        ]);

        return redirect()->route('outcomes')->with('success', "Successfully Created Outcome!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function show(Outcome $outcome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $outcome = Outcome::find($id);
        if ($outcome) {
            return view('outcome/edit', ['outcome' => $outcome]);
        } else {
            return redirect()->route('outcomes')->with('error', "Outcome cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outcome $outcome)
    {
        $fields = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'id' => 'required',
        ]);

        $outcome = Outcome::find($fields['id']);
        if ($outcome) {
            $outcome->update([
                'title' => $fields['title'],
                'date' => date('Y-m-d', strtotime($fields['date'])),
                'amount' => $fields['amount'],
                'remark' => $request->remark,
            ]);

            return redirect()->route('outcomes')->with('success', "Successfully Updated Outcome!");
        }
        else{
            return redirect()->route('outcomes')->with('error', "Outcome cannot be found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $outcome = Outcome::find($fields['delete_id']);
        if ($outcome) {
            $outcome->delete();
            return redirect()->route('outcomes')->with('success', "Successfully Deleted Outcome!");
        } else {
            return redirect()->route('outcomes')->with('error', "Outcome cannot be found!");
        }
    }
}
