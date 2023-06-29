<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transaction.index');
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'date_from'  => 'required',
            'date_to'    => 'required',
        ]);

        $date_from  = $request->date_from;
        $date_to    = $request->date_to;

        $transactions = Transaction::with('customer')->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->get();

        //get total donation by range date    
        $total = Transaction::with('customer')->whereDate('created_at', '>=', $request->date_from)->whereDate('created_at', '<=', $request->date_to)->sum('total');

        return view('admin.transaction.index', compact('transactions', 'total'));
    }

    public function show($invoice)
    {
        $transaction = Transaction::with('product')->where('invoice', $invoice)->first();


        return view('admin.transaction.show', compact('transaction'));
    }
}
