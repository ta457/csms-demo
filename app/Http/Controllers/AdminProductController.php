<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index($products = null)
    {   
        if (is_null($products)) {
            $products = Product::oldest();
        }

        $props = [
            'products' => $products->paginate(10)
        ];

        return view('admin.products', ['props' => $props]);
    }
}
