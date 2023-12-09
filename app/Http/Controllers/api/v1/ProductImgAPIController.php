<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImgAPIController extends Controller
{
  
  public function delete(ProductImage $img)
  {
    $img->delete();
  }
}
