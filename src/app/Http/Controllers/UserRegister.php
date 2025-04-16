<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use App\Mail\MakeUserBeneficiaryMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserBeneficiaryrRequestMail;
use App\Mail\UserBeneficiaryRequestOriginatorMail;
use App\Models\DataDeletionRequest;
use Illuminate\Support\Facades\Log;

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

    public function deleteMyAccount(Request $request)
    {
        $email = $request->email;
        $reason = $request->reason;
        $details = $request->details;

        $reason = $reason . ' - ' . $details;

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'No account was found with the associated email!'], 404);
        }
        $dataDeletionRequest = new DataDeletionRequest(
            [
                'user_id' => $user->id,
                'reason' => $reason,
                'status' => 'pending',
                'data_to_delete' => 'all'
            ]
        );

        $dataDeletionRequest->save();

        $user->delete();

        return response()->json(['message' => 'Request to delete your account has been successfully submitted.']);
    }

    // sendEmailVerificationOtp, sending email verification otp without queue
    public function sendEmailLoginOtp(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'No account was found with the associated email!'], 404);
        }
        $otp = $request->otp;
        try {
            Mail::to($user->email)
                ->send(new \App\Mail\EmailVerificationOtpMail($otp, $user->name));

            return response()->json(['message' => 'Email Login Verification OTP has been sent successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error sending email: ' . $th->getMessage());
            return response()->json(['message' => 'Error sending Login Verification OTP' . $th->getMessage()], 500);
        }
    }
}