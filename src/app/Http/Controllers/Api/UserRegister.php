<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;


class UserRegister extends Controller
{

    public function revokePermission(Request $request)
    {
        $user = User::where('email', $request->userEmail)->first();
        $user->revokePermissionTo($request->permission);
        return response()->json([
            "results" => 'success',
        ]);
    }
    public function assignPermissions(Request $request)
    {
        $asigningPermissions = $request->permissions;

        foreach ($asigningPermissions['user'] as $selectedUser) {

            $frontRowUser = User::where('email', $selectedUser['email'])->first();

            //assigning permissions
            if (array_key_exists('permissions', $asigningPermissions)) {
                foreach ($asigningPermissions['permissions'] as $permission) {
                    $frontRowUser->givePermissionTo($permission);


                }
            }
        }

        return apiResponse('success');
    }
}
