<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Movie;
use App\Models\PaymentTransaction;
use App\Models\UserWallet;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        //setting api token
        $user = Auth::user();
        $userApiToken = PersonalAccessToken::where('tokenable_id', $user->id)->first();
        $userApiToken = $user->createToken($user->name)->plainTextToken;
        $currentUser = User::where('id', $user->id)->first();
        $currentUser->api_token =  $userApiToken;
        $currentUser->save();
        $myWallet = UserWallet::where('user_id', $user->id)->first();

        //charts data
        list(
            $eventsChart,
            $moviesChart,
            $transactionsChart,
            $events,
            $movies,
            $allTransactions,
            $successTransactions,
            $failedTransactions
        ) = $this->getChartData($currentUser);


        return Inertia::render('Dashboards/Dashboard', [
            "eventsChart" => $eventsChart,
            "moviesChart" => $moviesChart,
            "transactionsChart" => $transactionsChart,
            "events" => $events,
            "movies" => $movies,
            "allTransactions" => $allTransactions,
            "successTransactions" => $successTransactions,
            "failedTransactions"=>$failedTransactions,
            "myWallet" => $myWallet
        ]);
    }


    private function getChartData($currentUser)
    {
        $userPermissionDetails = $currentUser->getAllPermissions();
        $permissions = [];
        foreach ($userPermissionDetails as $perm) {
            array_push($permissions, $perm->name);
        }
        $isAdmin = in_array('admin', $permissions);
        $eventsChart = [];
        $moviesChart = [];
        $transactionsChart = [];
        $allTransactions = [];
        $successTransactions = [];
        $failedTransactions = [];
        $months = collect();
        $startDate = Carbon::now()->startOfMonth()->subMonths(5);
        $endDate = Carbon::now()->endOfMonth();
        $movies = [];
        $events = [];

        for (
            $i = 5;
            $i >= 0;
            $i--
        ) {
            $months->push(Carbon::now()->subMonths($i)->format('F'));
        }

        if ($isAdmin) {

            //movies
            $movies = Movie::where('is_active', true)->latest()->take(5)->get();
            $events = Event::where('is_active', true)->latest()->take(5)->get();
            $allTransactions = PaymentTransaction::with(['user'])->latest()->take(7)->get();
            $successTransactions = PaymentTransaction::with(['user'])->where('txn_status', 'paid')->latest()->take(7)->get();
            $failedTransactions = PaymentTransaction::with(['user'])->where('txn_status', 'failed')->latest()->take(7)->get();


            $eventRecords = Event::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_active', true)
                ->get()
                ->groupBy(function ($theEvent) {
                    return Carbon::parse($theEvent->created_at)->format('F');
                })
                ->map(function ($theEvents) {
                    return count($theEvents);
                });

            $movieRecords = Movie::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_active', true)
                ->get()
                ->groupBy(function ($theMovie) {
                    return Carbon::parse($theMovie->created_at)->format('F');
                })
                ->map(function ($theMovies) {
                    return count($theMovies);
                });

            $paymentRecords = PaymentTransaction::whereBetween('created_at', [$startDate, $endDate])

                ->get()
                ->groupBy(function ($thetransaction) {
                    return Carbon::parse($thetransaction->created_at)->format('F');
                })
                ->map(function ($thetransactions) {
                    return count($thetransactions);
                });

            $eventsChart = $months->map(function ($month) use ($eventRecords) {
                return [
                    'month' => $month,
                    'records' => $eventRecords->get($month, 0)
                ];
            })->values()->toArray();

            $moviesChart =
                $months->map(function ($month) use ($movieRecords) {
                    return [
                        'month' => $month,
                        'records' => $movieRecords->get($month, 0)
                    ];
                })->values()->toArray();
            $transactionsChart =
                $months->map(function ($month) use ($paymentRecords) {
                    return [
                        'month' => $month,
                        'records' => $paymentRecords->get($month, 0)
                    ];
                })->values()->toArray();
        } else {
            //movies
            $movies = Movie::where('beneficiary_id', $currentUser->id)->where('is_active', true)->latest()->take(5)->get();
            $events = Event::where('beneficiary_id', $currentUser->id)->where('is_active', true)->latest()->take(5)->get();
            $allTransactions = PaymentTransaction::with(['user'])->where('user_id', $currentUser->id)->latest()->take(7)->get();
            $successTransactions = PaymentTransaction::with(['user'])->where('user_id', $currentUser->id)->where('txn_status', 'paid')->latest()->take(7)->get();
            $failedTransactions = PaymentTransaction::with(['user'])->where('user_id', $currentUser->id)->where('txn_status', 'failed')->latest()->take(7)->get();

            $eventRecords = Event::whereBetween('created_at', [$startDate, $endDate])
                ->where('beneficiary_id', $currentUser->id)
                ->where('is_active', true)
                ->get()
                ->groupBy(function ($theEvent) {
                    return Carbon::parse($theEvent->created_at)->format('F');
                })
                ->map(function ($theEvents) {
                    return count($theEvents);
                });

            $movieRecords = Movie::whereBetween('created_at', [$startDate, $endDate])
                ->where('beneficiary_id', $currentUser->id)
                ->where('is_active', true)
                ->get()
                ->groupBy(function ($theMovie) {
                    return Carbon::parse($theMovie->created_at)->format('F');
                })
                ->map(function ($theMovies) {
                    return count($theMovies);
                });

            $paymentRecords = PaymentTransaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('user_id', $currentUser->id)
                ->get()
                ->groupBy(function ($thetransaction) {
                    return Carbon::parse($thetransaction->created_at)->format('F');
                })
                ->map(function ($thetransactions) {
                    return count($thetransactions);
                });

            $eventsChart = $months->map(function ($month) use ($eventRecords) {
                return [
                    'month' => $month,
                    'records' => $eventRecords->get($month, 0)
                ];
            })->values()->toArray();

            $moviesChart =
                $months->map(function ($month) use ($movieRecords) {
                    return [
                        'month' => $month,
                        'records' => $movieRecords->get($month, 0)
                    ];
                })->values()->toArray();
            $transactionsChart =
                $months->map(function ($month) use ($paymentRecords) {
                    return [
                        'month' => $month,
                        'records' => $paymentRecords->get($month, 0)
                    ];
                })->values()->toArray();
        }

        return [
            $eventsChart,
            $moviesChart,
            $transactionsChart,
            $events,
            $movies,
            $allTransactions,
            $successTransactions,
            $failedTransactions
        ];
    }
}
