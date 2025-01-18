<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TransactionsController extends Controller
{
    public function myTransactions(Request $request)
    {
        $user = Auth::user();
        $currentUser = User::where('id', $user->id)->first();
        $userPermissionDetails = $currentUser->getAllPermissions();
        $permissions = [];
        $transactions = [];
        foreach ($userPermissionDetails as $perm) {
            array_push($permissions, $perm->name);
        }
        $isAdmin = in_array('admin', $permissions);
        if ($isAdmin) {
            $transactions = PaymentTransaction::orderBy('created_at', 'desc')->paginate(12);
        } else {
            $transactions = PaymentTransaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(12);
        }

        return \Inertia\Inertia::render(
            'Transactions/MyTransactions',
            ["transationDetails" => $transactions]
        );
    }
}
