<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = Customer::count();

        $products = Product::count();

        $transactions = Transaction::where('status', 'success')->sum('total');

        return view('admin.dashboard.index', compact('customers', 'products', 'transactions'));
    }
}
