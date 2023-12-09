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

  public function show($id)
  {
    $categories = Category::find($id);
    return response()->json($categories);
  }

}