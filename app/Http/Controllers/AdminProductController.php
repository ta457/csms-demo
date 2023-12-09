<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index($products = null)
    {   
        if (is_null($products)) {
            $products = Product::with('images')->oldest();
        }

        $props = [
            'categories' => Category::all(),
            'products' => $products->paginate(10)
        ];

        return view('admin.products', ['props' => $props]);
    }

    public function filter()
    {   
        $products = Product::oldest();

        if(request('sort_by_time') == 'latest') {
            $products = Product::latest();
        }

        if(request('search')) {
            $products->where('name', 'like', '%' . request('search') . '%');
        }

        if(request('filter_category')) {
            $products->where('category_id', 'like', '%' . request('filter_category') . '%');
        }

        return $this->index($products);
    }

    public function store()
    {   
        $attributes = request()->validate([
            'name' => 'required|max:255|min:1',
            'description' => 'required|max:255|min:1',
            'price' => 'required|integer',
            'category_id' => 'required|integer'
        ]);
        $attributes['category_id'] = $attributes['category_id'] * 1;
        if (!(Product::where('name', $attributes['name'])->get()->count() > 0)) {
            Product::create($attributes);
            return redirect('/admin/products')->with('success', 'New product added');
        } else {
            return redirect('/admin/products')->with('failed', 'Product name is already existed');
        }
    }

    public function update(Product $product)
    {
        $attributes = request()->validate([
            'name' => 'required|max:255|min:1',
            'description' => 'required|max:255|min:1',
            'price' => 'required|integer',
            'category_id' => 'required|integer',
            'files.*' => 'required|image|max:4096'
        ]);
        $attributes['category_id'] = $attributes['category_id'] * 1;
        $product->update([
            'name' => $attributes['name'],
            'description' => $attributes['description'],
            'price' => $attributes['price'],
            'category_id' => $attributes['category_id']
        ]);

        foreach ($attributes['files'] as $file) {
            ProductImage::create([
                'product_id' => $product->id,
                'file' => $file->store('product-images')
            ]);
        }

        return redirect("/admin/products")->with('success', 'Your changes have been saved');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product deleted');
    }

    public function destroyAll(Request $request)
    {
        $selectedProducts = $request->input('selected', []);
        
        $products = Product::whereIn('id', $selectedProducts)->get();

        foreach ($products as $product) {
            $product->delete();
        }
        $message = ['success', 'Selected products have been deleted'];
        return redirect('/admin/products')->with($message[0],$message[1]);
    }
}
