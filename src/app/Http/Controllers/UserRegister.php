<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Mail\MakeUserBeneficiaryMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserBeneficiaryrRequestMail;
use App\Mail\UserBeneficiaryRequestOriginatorMail;



class UserRegister extends Controller
{
    public function index()
    {

        $users = User::orderBy('created_at', 'desc')->paginate(6);
        $userAssignPermission = User::select('name', 'id', 'email')->get();
        $seededPermissions = Permission::select('name')->get();
        $inactiveDeneficiaries = User::where('beneficiary_status', 'inactive')->paginate(6);
        $deactiveDeneficiaries = User::where('beneficiary_status', 'deactivated')->paginate(6);


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

        try {
            $message = (new MakeUserBeneficiaryMail($theUser->name))
                ->onQueue('emails');

            Mail::to($theUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deactivateBeneficiary(Request $request)
    {
        $theUser = User::where('id', $request->userId)->first();
        $theUser->user_type = 'ticket_buyer';
        $theUser->beneficiary_status = 'deactivated';
        $theUser->save();

        $theUser->revokePermissionTo('beneficiary');
    }
    public function userbeneficiaryrequest(Request $request)
    {
        $theUser = User::where('id', $request->userId)->first();
        $theUser->user_type = 'beneficiary';
        $theUser->beneficiary_status = 'inactive';
        $theUser->save();

        $admins = User::permission('admin')->get();

        foreach ($admins as $admin) {
            try {
                $message = (new UserBeneficiaryrRequestMail($admin->name, $theUser->name))
                    ->onQueue('emails');

                Mail::to($admin->email)
                    ->queue($message);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        try {
            $message = (new UserBeneficiaryRequestOriginatorMail($theUser->name))
                ->onQueue('emails');

            Mail::to($theUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
