<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAPIController extends Controller
{
  public function index()
  {
    $products = Product::all();
    return response()->json($products);
  }

  public function show(Product $product)
  {
    return response()->json($product);
  }

  public function update(Product $product)
  {
    $attributes = request()->validate([
      'name' => 'required|max:255|min:1',
      'description' => 'required|max:255|min:1',
      'price' => 'required|integer',
      'category_id' => 'required|integer'
    ]);
    $product->update($attributes);
  }

  public function delete(Product $product)
  {
    $product->delete();
  }
}
