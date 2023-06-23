<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    protected function redirectWithMessage($category)
    {
        if ($category) {
            return redirect()->route('admin.category.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect()->route('admin.category.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function index()
    {
        $categories = Category::latest()->when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name' => 'required|unique:categories'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        $category = Category::create([
            'image' => $image->hashName(),
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ]);

        return $this->redirectWithMessage($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ];

        if ($request->hasFile('image')) {
            Storage::disk('local')->delete('public/categories/' . basename($category->image));

            $image = $request->file('image');
            $image->storeAs('public/categories' . $image->hashName());

            $updateData['image'] = $image->hashName();
        }

        $category->update($updateData);

        return $this->redirectWithMessage($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        Storage::disk('local')->delete('public/categories/' . basename($category->image));


        $category->delete();

        if ($category) {
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
