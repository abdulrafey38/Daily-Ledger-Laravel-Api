<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Support\Facades\Auth;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $product = Auth::user()->products;


        return response()->json(['product'=> ProductResource::collection($product)],200);
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
            'name'=>['required'],
            'price'=>['required'],
            'supplier_id'=>['required'],
            
        ]);

        $product =  new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->user_id = Auth::user()->id;
        $product->supplier_id = $request->supplier_id;
        $product->save();
        error_log($product);
        return response()->json([
            "product"=>$product
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
        $product =Product::find($id);
        if(!$product)
        {
            return response()->json([
                'Message'=>'Item Not Found'
            ],400);
        }
        return response()->json([
            'success'=>true,
            'product'=>$product
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
            'price'=>['required'],
            'user_id'=>['required'],
            'supplier_id'=>['required'],
            
        ]);
        
        $product = Product::find($id);
        if(is_null($product))
        {
            return response()->json([
                'Not Found',400
            ]);
        }
        else{
            // $product->name = $request->name;
            // $product->price=$request->price;    
            // $product->user_id =  $request->user_id;
            // $product->supplier_id =  $request->supplier_id;
            // $product->save();
            $product->update($request->all());
            return response()->json([
                'product'=>$product
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
        $product =  Product::find($id);
        if(is_null($product))
        {
            return response()->json('Item Not Found',404);
        }
        $product->delete();
        return response()->json("Deleted Successfully!!",200);
    }
//=======================================================================
    public function getSupplierProducts($id)
    {
        error_log($id);
        error_log('hjdeghde');
        $products = Product::where('supplier_id',$id)->get();
        error_log($products);
        return response()->json(['supplierProduct'=> ProductResource::collection($products)],200);
    }
}
