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
    $product->load('images');
    $responseData = [
      'id' => $product->id,
      'name' => $product->name,
      'price' => $product->price,
      'quantity' => $product->quantity,
      'description' => $product->description,
      'category_id' => $product->category_id,
      'provider_id' => $product->provider_id,
      'created_at' => $product->created_at->toDateTimeString(),
      'updated_at' => $product->updated_at->toDateTimeString(),
      'images' => $product->images,
    ];

    return response()->json($responseData);
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
