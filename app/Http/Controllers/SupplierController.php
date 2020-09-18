<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Resources\Supplier as SupplierResource;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= Auth::user();
    
        $supplier = $user->suppliers->sortByDesc('created_at');
       

        return  \response()->json([
            'supplier'=>SupplierResource::collection($supplier)
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
        error_log($request);
        $request->validate([
            'name'=>['required'],
            'phone_number'=>['required'],    
            
        ]);
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->phone_number = $request->phone_number;
        $supplier->user_id=Auth::user()->id;
        $supplier->save();

        return response()->json([
            "supplier"=>$supplier
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $supplier = Supplier::find($id);
        if(!$supplier)
        {
            return response()->json([
                'Message'=>'Item Not Found'
            ],400);
        }
        return response()->json([
            'success'=>true,
            'supplier'=>$supplier
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
            'name'=>['required'],
            'phone_number'=>['required'],
            
        ]);
        
        $supplier =  Supplier::find($id);
        if(is_null($supplier))
        {
            return response()->json([
                'Not Found',400
            ]);
        }
        else{
            $supplier->update($request->all());
            return response()->json([
                'supplier'=>$supplier
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
        
        $supplier =  Supplier::find($id);
        if(is_null($supplier))
        {
            return response()->json('Item Not Found',404);
        }
        $supplier->delete();
        return response()->json(["Deleted Successfully!!"],200);
    }
}
