<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Transaction as TransactionResource;
use App\Product;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {
        
        $user =  Auth::user();
        error_log($user);

        return response()->json([
            'transaction'=>  TransactionResource::collection($user->transactions->sortByDesc('date'))
        ],200);
    }


    public function daily()
    
    {
        $t = Carbon::now();

        $date = $t->year.'-'.today()->format('m').'-'.$t->day;
        error_log($date);
        
        $user =  Auth::user();
       
        return response()->json([
            'transaction'=>  TransactionResource::collection($user->transactions->where('date',$date)->sortByDesc('date'))
        ],200);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

        $request->validate([
            
            'supplier_id'=>['required'],
            'product_id'=>['required'],
            'month_id'=>['required'],
            'date'=>['required'], 
            'quantity'=>['required'],
        ]);
       
        
        $productPrice = Product::where('id',$request->product_id)->pluck('price');
        


        $price = $request->quantity * $productPrice[0];
        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->product_id = $request->product_id;
        $transaction->supplier_id = $request->supplier_id;
        $transaction->month_id = $request->month_id;
        $transaction->date = $request->date;
        $transaction->quantity = $request->quantity;
        $transaction->price = $price;
        $transaction->save();
        return response()->json(201);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {  
        
        $transaction =Transaction::find($id);
        if(!$transaction)
        {
            return response()->json([
                'Message'=>'Item Not Found'
            ],400);
        }
        return response()->json([
            'success'=>true,
            'transaction'=>$transaction
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'user_id'=>['required'],
            'supplier_id'=>['required'],
            'product_id'=>['required'],
            'month_id'=>['required'],
            'date'=>['required'], 
            'quantity'=>['required'],
            'price'=>['required'],
            
        ]);
        $transaction = Transaction::find($id);
        if(is_null($transaction))
        {
            return response()->json([
                'Not Found',400
            ]);
        }
        else{
            
            $transaction->update($request->all());
            return response()->json([
                'transaction'=>$transaction
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $transaction =  Transaction::find($id);
        if(is_null($transaction))
        {
            return response()->json('Item Not Found',404);
        }
        $transaction->delete();
        return response()->json("Deleted Successfully!!",200);
    }
//=======================================================================
    public function monthDT($id)
    {
 
        $transactionPMD = Transaction::where('month_id',$id)->get();
        return response()->json(['transaction'=>
            TransactionResource::collection($transactionPMD->sortByDesc('date'))]
        ,200);
    }
//========================================================================
    public function monthlySpendAmount($id)
    {

        return response()->json([
            'amount'=>Transaction::where('month_id',$id)->sum('price')],200);
    }
}
