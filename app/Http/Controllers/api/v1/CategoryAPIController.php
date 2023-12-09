<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAPIController extends Controller
{
  public function index()
  {
    $categories = Category::all();
    return response()->json($categories);
  }

  public function show(Category $category)
  {
    $responseData = [
      'id' => $category->id,
      'name' => $category->name,
      'description' => $category->description,
      'created_at' => $category->created_at->toDateTimeString(),
      'updated_at' => $category->updated_at->toDateTimeString(),
    ];

    return response()->json($responseData);
  }

}