<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Outcome;
use App\Models\Order;

class ReportController extends Controller
{
    public function profitLoss(Request $request){
        $fields = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $start_date = date('Y-m-d',strtotime($fields['start_date']));
        $end_date = date('Y-m-d',strtotime($fields['end_date']));
        $incomes = Income::where('date','>=',$start_date)->where('date','<=',$end_date)->get();
        $outcomes = Outcome::where('date','>=',$start_date)->where('date','<=',$end_date)->get();
        $orders = Order::whereDate('date','>=',$start_date)->whereDate('date','<=',$end_date)->where('status','approved')->get();
        return view('report/profit-loss',['incomes' => $incomes,'outcomes' => $outcomes,'orders' => $orders]);
    }
}
