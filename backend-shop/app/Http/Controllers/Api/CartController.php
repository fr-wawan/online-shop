<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::with('product')->where('customer_id', auth()->guard('api')->user()->id)->get();

        $cartsCount = Cart::where('customer_id', auth()->guard('api')->user()->id)->count();

        return response()->json([
            'success' => true,
            'message' => 'List Data Carts : ' . auth()->guard('api')->user()->id,
            'data' => $carts,
            'count' => $cartsCount
        ], 200);
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->id)->first();

        $existingCart = Cart::where('product_id', $product->id)->where('customer_id', auth()->guard('api')->user()->id)->first();

        if ($existingCart) {
            $existingCart->quantity += $request->quantity;
            $existingCart->save();
        } else {
            $cart = Cart::create([
                'product_id' => $product->id,
                'customer_id' => auth()->guard('api')->user()->id,
                'quantity' => $request->quantity,
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->input('quantity');
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated',
            'data' => $cart
        ]);
    }

    public function destroy($id)
    {

        $cart = Cart::findOrFail($id);

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data successfully deleted',
            'data' => $cart
        ], 200);
    }
}
