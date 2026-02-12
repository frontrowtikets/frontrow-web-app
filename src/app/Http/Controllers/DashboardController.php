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
        if (!$user->api_token) {
            $userApiToken = $user->createToken($user->name)->plainTextToken;
            $user->api_token = $userApiToken;
            $user->save();
        }
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
        ) = $this->getChartData($user);


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

            //movies & events (select only needed columns)
            $movies = Movie::where('is_active', true)->select('id', 'title', 'thumbnail_url', 'created_at')->latest()->take(5)->get();
            $events = Event::where('is_active', true)->select('id', 'title', 'thumbnail_url', 'start_date', 'created_at')->latest()->take(5)->get();

            // Single transaction query instead of 3 separate ones
            $recentTransactions = PaymentTransaction::with(['user:id,name,email'])->latest()->take(15)->get();
            $allTransactions = $recentTransactions->take(7)->values();
            $successTransactions = $recentTransactions->where('txn_status', 'paid')->take(7)->values();
            $failedTransactions = $recentTransactions->where('txn_status', 'failed')->take(7)->values();

            // Use DB-level aggregation instead of loading all records into PHP
            $eventRecords = Event::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_active', true)
                ->selectRaw("TO_CHAR(created_at, 'FMMonth') as month, count(*) as count")
                ->groupByRaw("TO_CHAR(created_at, 'FMMonth'), EXTRACT(MONTH FROM created_at)")
                ->orderByRaw("EXTRACT(MONTH FROM created_at)")
                ->pluck('count', 'month');

            $movieRecords = Movie::whereBetween('created_at', [$startDate, $endDate])
                ->where('is_active', true)
                ->selectRaw("TO_CHAR(created_at, 'FMMonth') as month, count(*) as count")
                ->groupByRaw("TO_CHAR(created_at, 'FMMonth'), EXTRACT(MONTH FROM created_at)")
                ->orderByRaw("EXTRACT(MONTH FROM created_at)")
                ->pluck('count', 'month');

            $paymentRecords = PaymentTransaction::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw("TO_CHAR(created_at, 'FMMonth') as month, count(*) as count")
                ->groupByRaw("TO_CHAR(created_at, 'FMMonth'), EXTRACT(MONTH FROM created_at)")
                ->orderByRaw("EXTRACT(MONTH FROM created_at)")
                ->pluck('count', 'month');

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
            //movies & events (select only needed columns)
            $movies = Movie::where('beneficiary_id', $currentUser->id)->where('is_active', true)->select('id', 'title', 'thumbnail_url', 'created_at')->latest()->take(5)->get();
            $events = Event::where('beneficiary_id', $currentUser->id)->where('is_active', true)->select('id', 'title', 'thumbnail_url', 'start_date', 'created_at')->latest()->take(5)->get();

            // Single transaction query instead of 3 separate ones
            $recentTransactions = PaymentTransaction::with(['user:id,name,email'])->where('user_id', $currentUser->id)->latest()->take(15)->get();
            $allTransactions = $recentTransactions->take(7)->values();
            $successTransactions = $recentTransactions->where('txn_status', 'paid')->take(7)->values();
            $failedTransactions = $recentTransactions->where('txn_status', 'failed')->take(7)->values();

            // Use DB-level aggregation instead of loading all records into PHP
            $eventRecords = Event::whereBetween('created_at', [$startDate, $endDate])
                ->where('beneficiary_id', $currentUser->id)
                ->where('is_active', true)
                ->selectRaw("TO_CHAR(created_at, 'FMMonth') as month, count(*) as count")
                ->groupByRaw("TO_CHAR(created_at, 'FMMonth'), EXTRACT(MONTH FROM created_at)")
                ->orderByRaw("EXTRACT(MONTH FROM created_at)")
                ->pluck('count', 'month');

            $movieRecords = Movie::whereBetween('created_at', [$startDate, $endDate])
                ->where('beneficiary_id', $currentUser->id)
                ->where('is_active', true)
                ->selectRaw("TO_CHAR(created_at, 'FMMonth') as month, count(*) as count")
                ->groupByRaw("TO_CHAR(created_at, 'FMMonth'), EXTRACT(MONTH FROM created_at)")
                ->orderByRaw("EXTRACT(MONTH FROM created_at)")
                ->pluck('count', 'month');

            $paymentRecords = PaymentTransaction::whereBetween('created_at', [$startDate, $endDate])
                ->where('user_id', $currentUser->id)
                ->selectRaw("TO_CHAR(created_at, 'FMMonth') as month, count(*) as count")
                ->groupByRaw("TO_CHAR(created_at, 'FMMonth'), EXTRACT(MONTH FROM created_at)")
                ->orderByRaw("EXTRACT(MONTH FROM created_at)")
                ->pluck('count', 'month');

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
