<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::with('category')->when(request()->q, function ($products) {

        $products = Product::with(['category', 'transaction'])
            ->withCount('transaction as transaction_count')
            ->orderBy('transaction_count', 'desc')
            ->simplePaginate(8);

        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $products
        ], 200);
    }

    function newestProduct()
    {
        $category_id = request()->category_id ? explode(',', request()->category_id) : null;

        $products = Product::with('category')
            ->when(request()->q, function ($query) {
                $query->where('title', 'like', '%' . request()->q . '%');
            })
            ->when($category_id, function ($query, $category_id) {
                $query->whereIn('category_id', $category_id);
            })
            ->latest()
            ->paginate(12);


        return response()->json([
            'success' => true,
            'message' => 'List Popular Product',
            'data' => $products
        ], 200);
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->first();


        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Product : ' . $product->title,
                'data' => $product

            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Product Tidak Ditemukan'
        ], 404);
    }
}
