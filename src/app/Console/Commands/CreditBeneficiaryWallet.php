<?php

namespace App\Console\Commands;

use App\Models\BusinessSetting;
use App\Models\MovieTicket;
use App\Models\User;
use App\Models\UserEventTicket;
use App\Models\UserWallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreditBeneficiaryWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:credit-beneficiary-wallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Credit beneficiary wallets for movie and event tickets after deducting service fee';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting beneficiary wallet crediting process...");
        Log::info("Starting beneficiary wallet crediting process...");

        try {
            // process movie tickets first
            $this->processMovieTickets();
        } catch (\Exception $e) {
            $this->error("Error processing movie tickets: " . $e->getMessage());
            Log::error("Error processing movie tickets: " . $e->getMessage());
        }
        // wait for 5 seconds before processing event tickets
        sleep(5);
        try {
            // process event tickets
            $this->processEventTickets();
        } catch (\Exception $e) {
            $this->error("Error processing event tickets: " . $e->getMessage());
            Log::error("Error processing event tickets: " . $e->getMessage());
        }

        $this->info("Beneficiary wallet crediting process completed.");
        Log::info("Beneficiary wallet crediting process completed.");
    }

    //
    private function creditBeneficiaryWallet($walletId, $amount)
    {
        $wallet = UserWallet::find($walletId);
        if ($wallet) {
            $wallet->balance += $amount;
            $wallet->save();
            return true;
        }
        return false;
    }

    private function processMovieTickets()
    {
        $tickets = MovieTicket::where('beneficiary_credited', false)
            ->whereIn('ticket_status', ['booked', 'confirmed'])
            ->with(['movie', 'theatre', 'movie.beneficiary', 'movie.beneficiary.wallet'])
            ->get();
        if ($tickets->isEmpty()) {
            $this->info("No movie tickets found for beneficiary crediting.");
            Log::info("No movie tickets found for beneficiary crediting.");
            return;
        }
        $this->info("Found " . $tickets->count() . " movie tickets for beneficiary crediting.");
        Log::info("Found " . $tickets->count() . " movie tickets for beneficiary crediting.");

        $businessSettings = BusinessSetting::first();
        $serviceFee = $businessSettings->service_fee;

        foreach ($tickets as $ticket) {
            $beneficiary = $ticket->movie->beneficiary;
            $wallet = $beneficiary ? $beneficiary->wallet : null;
            if (!$beneficiary) {
                $this->info("No beneficiary found for movie ID: {$ticket->movie->id}");
                Log::info("No beneficiary found for movie ID: {$ticket->movie->id}");
                continue;
            }
            if (!$wallet) {
                $this->info("No wallet found for beneficiary ID: {$beneficiary->id}; creating one...");
                Log::info("No wallet found for beneficiary ID: {$beneficiary->id}; creating one...");
                // create wallet for beneficiary
                $wallet = $this->createUserWalletIfNotExists($beneficiary->id);
                if (!$wallet) {
                    $this->info("Failed to create wallet for beneficiary ID: {$beneficiary->id}");
                    Log::info("Failed to create wallet for beneficiary ID: {$beneficiary->id}");
                    continue;
                }
            }

            $walletId = $wallet->id;
            // calculate amount to credit after deducting service fee
            $amount = $ticket->theatre->ticket_price - $serviceFee;

            if ($amount <= 0) {
                $this->info("Calculated amount is less than or equal to zero for ticket ID: {$ticket->id}. Skipping.");
                Log::info("Calculated amount is less than or equal to zero for ticket ID: {$ticket->id}. Skipping.");
                continue;
            }
            $this->info("Crediting beneficiary wallet ID: $walletId with amount: $amount for ticket ID: {$ticket->id}");
            Log::info("Crediting beneficiary wallet ID: $walletId with amount: $amount for ticket ID: {$ticket->id}");

            if ($this->creditBeneficiaryWallet($walletId, $amount)) {
                $ticket->beneficiary_credited = true;
                $ticket->save();
                $this->info("Successfully credited beneficiary wallet for: {$beneficiary->name} for ticket ID: {$ticket->id}");
                Log::info("Successfully credited beneficiary wallet for: {$beneficiary->name} for ticket ID: {$ticket->id}");
            }
        }
    }

    private function processEventTickets()
    {
        $tickets = UserEventTicket::where('beneficiary_credited', false)
            ->with(['event', 'event.beneficiary', 'event.beneficiary.wallet'])
            ->get();
        if ($tickets->isEmpty()) {
            $this->info("No event tickets found for beneficiary crediting.");
            Log::info("No event tickets found for beneficiary crediting.");
            return;
        }
        $this->info("Found " . $tickets->count() . " event tickets for beneficiary crediting.");
        Log::info("Found " . $tickets->count() . " event tickets for beneficiary crediting.");

        $businessSettings = BusinessSetting::first();
        $serviceFee = $businessSettings->service_fee;

        foreach ($tickets as $ticket) {
            $beneficiary = $ticket->event->beneficiary;
            $wallet = $beneficiary ? $beneficiary->wallet : null;

            if (!$beneficiary) {
                $this->info("No beneficiary found for event ID: {$ticket->event->id}");
                Log::info("No beneficiary found for event ID: {$ticket->event->id}");
                continue;
            }
            if (!$wallet) {
                $this->info("No wallet found for beneficiary ID: {$beneficiary->id}; creating one...");
                Log::info("No wallet found for beneficiary ID: {$beneficiary->id}; creating one...");
                // create wallet for beneficiary
                $wallet = $this->createUserWalletIfNotExists($beneficiary->id);
                if (!$wallet) {
                    $this->info("Failed to create wallet for beneficiary ID: {$beneficiary->id}");
                    Log::info("Failed to create wallet for beneficiary ID: {$beneficiary->id}");
                    continue;
                }
            }

            $walletId = $wallet->id;
            $amount = $ticket->total_amount - $serviceFee;

            if ($amount <= 0) {
                $this->info("Calculated amount is less than or equal to zero for ticket ID: {$ticket->id}. Skipping.");
                Log::info("Calculated amount is less than or equal to zero for ticket ID: {$ticket->id}. Skipping.");
                continue;
            }
            $this->info("Crediting beneficiary wallet ID: $walletId with amount: $amount for ticket ID: {$ticket->id}");
            Log::info("Crediting beneficiary wallet ID: $walletId with amount: $amount for ticket ID: {$ticket->id}");

            if ($this->creditBeneficiaryWallet($walletId, $amount)) {
                $ticket->beneficiary_credited = true;
                $ticket->save();
                $this->info("Successfully credited beneficiary wallet for: {$beneficiary->name} for ticket ID: {$ticket->id}");
                Log::info("Successfully credited beneficiary wallet for: {$beneficiary->name} for ticket ID: {$ticket->id}");
            }
        }
    }

    private function createUserWalletIfNotExists($userId)
    {
        try {
            $wallet = UserWallet::firstOrCreate(['user_id' => $userId,], ['balance' => 0,]);
            return $wallet;
        } catch (\Exception $e) {
            Log::error("Error creating wallet for user ID: $userId - " . $e->getMessage());
            return null;
        }
    }
}
