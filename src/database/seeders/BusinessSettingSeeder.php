<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the business settings
        \App\Models\BusinessSetting::updateOrCreate(
            ["id" => 1],
            [
                "service_fee" => 500,
                "share_percentage" => 5,
                "wallet_credit" => 0,
                "shareholder_wallet_id" => null,
            ]
        );
    }
}