<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketBuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticketBuyer = \App\Models\User::updateOrCreate(
            ["id" => 1],
            [
                "name" => "Test TicketBuyer",
                "email" => "ticketbuyer@frontrow.com",
                'email_verified_at' => date("Y-m-d H:i:s"),
                "phone_number" => '0722222222',
                "user_type" => 'ticket_buyer',
                "password" => bcrypt("buyer@123"),
            ]
        );

        //give user  admin permissions
        $ticketBuyer->givePermissionTo(
            'ticket_buyer',
        );
    }
}
