<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserRegister extends Controller
{
    public function makeUserAdmin(Request $request)
    {
        $user = User::where('email', $request->userEmail)->first();
        $user->givePermissionTo('admin');
        return response()->json([
            "results" => 'success',
        ]);
    }
    public function revokePermission(Request $request)
    {
        $user = User::where('email', $request->userEmail)->first();
        $user->revokePermissionTo($request->permission);
        return response()->json([
            "results" => 'success',
        ]);
    }
}
