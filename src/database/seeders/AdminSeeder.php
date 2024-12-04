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
                "name" => "Admin User",
                "email" => "admin@frontrow.com",
                'email_verified_at' => date("Y-m-d H:i:s"),
                "password" => bcrypt("frontrow@123"),
            ]
        );

        //give user  admin permissions
        $superAdmin->givePermissionTo(
            'ticket_buyer',
            'admin',
            'beneficiary',
            's_admin',
        );
    }
}
