<?php

namespace App\Http\Controllers\Api\Merchants;

use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Store::where('user_id', auth('sanctum')->user()->id)->First(), 200);
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
        $store = Store::where('user_id', auth('sanctum')->user()->id)->First();
        if(!is_null($store)){
            return response()->json(['message' => 'Store already exist.'], 422);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'vat' => 'required',
            'shipping_cost' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);

        }
        $user = auth('sanctum')->user();
        $data = $request->all();

        $data['user_id']= $user->id;
       return response()->json(Store::create($data), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $store = Store::where('user_id', auth('sanctum')->user()->id)->First();
        if(is_null($store)){
            return response()->json(['message' => 'No Store  exist.'], 422);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'vat' => 'required',
            'shipping_cost' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        
        $data = $store->update($request->all());
       return response()->json($store, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
