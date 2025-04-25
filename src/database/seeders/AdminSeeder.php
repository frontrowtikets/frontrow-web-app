<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = \App\Models\User::updateOrCreate(
            ["id" => 1],
            [
                "name" => "FrontRow Admin",
                "email" => "admin@frontrowtikets.com",
                'email_verified_at' => date("Y-m-d H:i:s"),
                "phone_number" => '07000000000',
                "user_type" => 'admin',
                "password" => bcrypt("frontrow@123"),
            ]
        );

        // 
        $financeAdmin = \App\Models\User::updateOrCreate(
            ["email" => 'finance@frontrowtikets.com'],
            [
                "name" => "Finance Admin",
                "email" => "finance@frontrowtikets.com",
                'email_verified_at' => date("Y-m-d H:i:s"),
                "phone_number" => '07500000000',
                "user_type" => 'admin',
                "password" => bcrypt("frontRow@321"),
            ]
        );

        //give user  admin permissions
        $superAdmin->givePermissionTo(
            'ticket_buyer',
            'admin',
            'beneficiary',
            's_admin',
        );

        // give user admin permissions
        $financeAdmin->givePermissionTo(
            'admin',
            'beneficiary',
            's_admin',
        );

        // create wallet for the finance admin if it does not exist
        $wallet = \App\Models\UserWallet::firstOrCreate(
            ['user_id' => $financeAdmin->id],
            ['balance' => 0]
        );
    }
}
