<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;


class UserRegister extends Controller
{
    public function index()
    {

        $users = User::paginate(15);
        $userAssignPermission = User::select('name', 'id', 'email')->get();
        $seededPermissions = Permission::select('name')->get();
        $inactiveDeneficiaries = User::where('beneficiary_status','inactive')->paginate(15);
        $deactiveDeneficiaries = User::where('beneficiary_status', 'deactivated')->paginate(15);


        return   \Inertia\Inertia::render('UserRegister/Users', [
            'users' => $users,
            'userNames' => $userAssignPermission,
            'seededPermissions' => $seededPermissions,
            'inactiveDeneficiaries' => $inactiveDeneficiaries,
            'deactiveDeneficiaries' => $deactiveDeneficiaries,
        ]);
    }

    public function userDetails(Request $request)
    {
        $user = User::where('id', $request->userID)->first();
        return   \Inertia\Inertia::render('UserRegister/UserDetails', [
            'userDetails' => $user,
        ]);
    }

    public function makeuserbeneficiary(Request $request)
    {
        $theUser = User::where('id', $request->userId)->first();
        $theUser->user_type = 'beneficiary';
        $theUser->beneficiary_status = 'active';
        $theUser->save();

        $theUser->givePermissionTo('beneficiary');
    }

    public function deactivateBeneficiary(Request $request)
    {
        $theUser = User::where('id', $request->userId)->first();
        $theUser->user_type = 'ticket_buyer';
        $theUser->beneficiary_status = 'deactivated';
        $theUser->save();

        $theUser->revokePermissionTo('beneficiary');
    }
    public function userbeneficiaryrequest( Request $request){
        $theUser = User::where('id', $request->userId)->first();
        $theUser->user_type = 'beneficiary';
        $theUser->beneficiary_status = 'inactive';
        $theUser->save();

    }
}
