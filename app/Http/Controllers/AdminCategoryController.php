<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index($categories = null)
    {   
        if (is_null($categories)) {
            $categories = Category::oldest();
        }

        $props = [
            'categories' => $categories->paginate(10)
        ];

        return view('admin.categories', ['props' => $props]);
    }

    public function filter()
    {   
        $categories = Category::oldest();

        if(request('sort_by_time') == 'latest') {
            $categories = Category::latest();
        }

        if(request('search')) {
            $categories->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');;
        }

        return $this->index($categories);
    }

    public function store()
    {   
        $attributes = request()->validate([
            'name' => 'required|max:255|min:1',
            'description' => 'required|max:255|min:1'
        ]);
        if (!(Category::where('name', $attributes['name'])->get()->count() > 0)) {
            Category::create($attributes);
            return redirect('/admin/categories')->with('success', 'New category added');
        } else {
            return redirect('/admin/categories')->with('failed', 'Category name is already existed');
        }
    }

    public function update(Category $category)
    {
        $attributes = request()->validate([
            'name' => 'required|max:255|min:1',
            'description' => 'required|max:255|min:1'
        ]);
        
        $category->update($attributes);
        return redirect("/admin/categories")->with('success', 'Your changes have been saved');
    }

    public function destroy(Category $category)
    {
        $products = $category->products;
        //for each products in this category, assign it to default category
        foreach ($products as $product) {
            $product->category_id = 1;
            $product->save();
        }
        //delete this category if it's not default category
        if ($category->id != 1) {
            $category->delete();
            return redirect('/admin/categories')->with('success', 'Category deleted');
        } else {
            return redirect('/admin/categories')->with('failed', 'Can\'t delete default category');
        }
    }

    public function destroyAll(Request $request)
    {
        $selectedCategories = $request->input('selected', []);
        
        $categories = Category::whereIn('id', $selectedCategories)->get();

        foreach ($categories as $category) {
            $category->delete();
        }
        $message = ['success', 'Selected categories have been deleted'];
        return redirect('/admin/categories')->with($message[0],$message[1]);
    }
}
