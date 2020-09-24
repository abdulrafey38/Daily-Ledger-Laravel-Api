<?php

namespace App\Http\Controllers;

use App\Product;
use App\Supplier;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function allSuppliers()
    {
        $supplier = Supplier::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'countS' => $supplier->count()
        ], 200);
    }


    public function allProducts()
    {

        $product = Product::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'countP' => $product->count()
        ], 200);
    }


    public function totalAmountSpend()
    {

        $amount = Transaction::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'amount' => $amount->sum('price')
        ], 200);
    }


    public function allTransaction()
    {

        $transaction = Transaction::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'countT' => $transaction->count()
        ], 200);
    }
}
