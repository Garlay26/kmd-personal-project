<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = Income::select('id', 'title', 'date', 'amount', 'remark')->orderbydesc('id')->get();
        return view('income/list', ['incomes' => $incomes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('income/create');
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

        $income = Income::create([
            'title' => $fields['title'],
            'date' => date('Y-m-d', strtotime($fields['date'])),
            'amount' => $fields['amount'],
            'remark' => $request->remark,
        ]);

        return redirect()->route('incomes')->with('success', "Successfully Created Income!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income = Income::find($id);
        if ($income) {
            return view('income/edit', ['income' => $income]);
        } else {
            return redirect()->route('incomes')->with('error', "Income cannot be found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        $fields = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'id' => 'required',
        ]);

        $income = Income::find($fields['id']);
        if ($income) {
            $income->update([
                'title' => $fields['title'],
                'date' => date('Y-m-d', strtotime($fields['date'])),
                'amount' => $fields['amount'],
                'remark' => $request->remark,
            ]);

            return redirect()->route('incomes')->with('success', "Successfully Updated Income!");
        }
        else{
            return redirect()->route('incomes')->with('error', "Income cannot be found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'delete_id' => 'required',
        ]);
        $income = Income::find($fields['delete_id']);
        if ($income) {
            $income->delete();
            return redirect()->route('incomes')->with('success', "Successfully Deleted Income!");
        } else {
            return redirect()->route('incomes')->with('error', "Income cannot be found!");
        }
    }
}
