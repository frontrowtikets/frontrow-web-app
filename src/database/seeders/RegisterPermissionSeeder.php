<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class RegisterPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'ticket_buyer',
            'admin',
            'beneficiary',
            's_admin'
        ];

        //current permissions
        $activePermissions = Permission::select('name')->get()->toArray();
        $tempPermArray = [];
        foreach ($activePermissions as $activePermission) {
            array_push($tempPermArray, $activePermission['name']);
        }

        //re-create permissions from the array
        foreach ($permissions as $permission) {
            if (!in_array($permission, $tempPermArray)) {
                Permission::create(['name' => $permission], ['name' => $permission]);
            }
        }

    }
}
