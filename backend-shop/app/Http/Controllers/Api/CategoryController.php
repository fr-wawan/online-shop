<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['product' => function ($query) {
            $query->latest();
        }])
            ->when(request()->has('q'), function ($query) {
                $slugs = explode(',', request()->q);
                $query->whereIn('slug', $slugs);
            })
            ->latest()
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Categories',
            'data' => $categories
        ]);
    }

    public function show($slug)
    {
        $category = Category::with('product')->where('slug', $slug)->first();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Product Berdasarkan Category : ' . $category->name,
                'data' => $category
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Tidak Ditemukan'
        ]);
    }
}
