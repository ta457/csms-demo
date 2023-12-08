<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAPIController extends Controller
{
    public function show($id)
    {
        $users = User::find($id);
        return response()->json($users);
    }
}
