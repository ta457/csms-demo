<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Provider;

class ProviderAPIController extends Controller
{
  public function show(Provider $provider)
    {
        $responseData = [
            'id' => $provider->id,
            'name' => $provider->name,
            'description' => $provider->description,
            'email' => $provider->email,
            'phone' => $provider->phone,
            'address' => $provider->address,
            'created_at' => $provider->created_at->toDateTimeString(),
            'updated_at' => $provider->updated_at->toDateTimeString(),
          ];
      
        return response()->json($responseData);
    }
}