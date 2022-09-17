<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = Store::where('user_id', $user->id)->first();
        if(is_null($store)){
            return response()->json(['message' => 'No Store exist.'], 422);
        }
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'is_vat_included' => 'boolean|required',
            'price' => 'required|gt:0'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = auth('sanctum')->user();
        
        $data = $request->all();
        if(!$request->is_vat_included){
            $data['price'] += $data['price'] * $store->vat / 100;
        }
        $data['store_id'] = $store->id;

       return response()->json(Product::create($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $store = Store::where('user_id', auth('sanctum')->user()->id)->first();
        if(is_null($store)){
            return response()->json(['message' => 'No Store exist.'], 422);
        }
        if($store->id != $product->store_id){
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $validator = Validator::make($request->all(), [
            'name_en' => 'required',
            'name_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'is_vat_included' => 'boolean|required',
            'price' => 'required|gt:0'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        
        $data = $request->all();
        if(!$request->is_vat_included){
            $data['price'] += $data['price'] * $store->vat / 100;
        }
        $product->update($data);

       return response()->json($product, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
