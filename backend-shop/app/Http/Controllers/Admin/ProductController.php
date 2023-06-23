<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected function redirectWithMessage($product)
    {
        if ($product) {
            //redirect dengan pesan sukses
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('admin.product.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->when(request()->q, function ($products) {
            $products = $products->where('title', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();

        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'title' => 'required|unique:products',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required',
            'description' => 'required',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $image->hashName(),
        ]);

        return $this->redirectWithMessage($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::latest()->get();
        return view('admin.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'title' => 'required|unique:products,title,' . $product->id,
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required',
            'description' => 'required',
        ]);

        $updateData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('local')->delete('public/products/' . basename($product->image));

            $image = $request->file('image');
            $image->storeAs('public/categories' . $image->hashName());

            $updateData['image'] = $image->hashName();
        }

        $product->update($updateData);

        return $this->redirectWithMessage($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Storage::disk('local')->delete('public/products/' . basename($product->image));


        $product->delete();

        if ($product) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
