<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BenficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beneficiary = \App\Models\User::updateOrCreate(
            ["id" => 1],
            [
                "name" => "Test Beneficiary",
                "email" => "beneficiary@frontrow.com",
                'email_verified_at' => date("Y-m-d H:i:s"),
                "phone_number" => '0711111111',
                "user_type" => 'beneficiary',
                "password" => bcrypt("frontrow@123"),
            ]
        );

        //give user  admin permissions
        $beneficiary->givePermissionTo(
            'ticket_buyer',
            'beneficiary',
        );
    }
}
