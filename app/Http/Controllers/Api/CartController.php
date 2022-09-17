<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_cart()
    {
        return response()->json( Cart::where('user_id', auth('sanctum')->user()->id)->with(
           [
                'cart_items',
                'cart_items.product'
        ])
        ->withCount([
            'cart_items AS totalCartItems' => function ($query) {
            $query->select(DB::raw("SUM(cart_items.quantity) as total_count"), DB::raw("SUM(cart_items.quantity * items.price) as total_price"))
            ->join('products', 'products.id', '=', 'cart_items.product_id');
        }])
        ->withCount([
            'cart_items AS totalCartItemsPrice' => function ($query) {
            $query->select(DB::raw("SUM(cart_items.quantity * products.price) as total_price"))
            ->join('products', 'products.id', '=', 'cart_items.product_id');
        }])
        ->first(), 200);
    }

    /**
     * add_product
     *
     * @return \Illuminate\Http\Response
     */
    public function add_product(Request $request)
    {
        $cart = Cart::where('user_id', auth('sanctum')->user()->id)->with('cart_items')->First();
        if(is_null($cart)){
            //create cart
            $cart = Cart::create([
                'user_id' => auth('sanctum')->user()->id
            ]);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|gt:0'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $product = Product::find($request->product_id);

        if($product->quantity < $request->quantity){
            return response()->json(['message' => 'Quantity too high.'], 422); 
        }

        //check if cart has this product if yes add quantity
        $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $request->product_id)
                    ->first();
        if(!is_null($cartItem)) {
            $quantity = $request->quantity? $cartItem->quantity + $request->quantity: $cartItem->quantity + 1;
            $cartItem->quantity = $quantity;
            if($product->quantity < $quantity){
                return response()->json(['message' => 'Quantity too high.'], 422); 
            }
            $cartItem->save();
        }else{
            $quantity =$request->quantity? $request->quantity: 1;
            $cartItem = CartItem::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'cart_id' => $cart->id,
            ]);
        }

        return response()->json($cartItem, 201);
    }
}
