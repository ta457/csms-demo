<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImgAPIController extends Controller
{
  
  public function delete(ProductImage $img)
  {
    Storage::delete($img->file);
    $img->delete();
  }
}
