<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'digits:1'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = auth('sanctum')->user();
        $userCart = Cart::where('user_id', $user->id)->with('CartItems')->first();
        if($userCart == null){
            $cart = Cart::create([
                "user_id" =>  $user->id
            ]);
        }else{
            $cart = $userCart;
        }
        $product = Product::Find($request->product_id);
        $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $request->product_id)
                    ->first();
        if(!is_null($cartItem)) {
            $quantity = $request->quantity? $request->quantity: $cartItem->quantity + 1;
            $cartItem->quantity = $quantity;
            $cartItem->price = $quantity * $item->price;
            $cartItem->save();
        }else{
            $quantity =$request->quantity? $request->quantity: 1;
            $cartItem = CartItem::create([
                'product_id'    => $request->product_id,
                'cart_id'  => $cart->id,
                'quantity' => $quantity,
                'price' => $count * $item->price
            ]);
        }

       return response()->json([
           'messege' => 'Item added!',
           'user' => $user
       ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        //
    }
}
