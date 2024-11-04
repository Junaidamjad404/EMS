<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $adminRole = DB::table('roles')->where('name', 'admin')->first();
$organizerRole = DB::table('roles')->where('name', 'event_organizer')->first();

$permissions = DB::table('permissions')->get();

// Assign all permissions to the admin role
if ($adminRole) {
    foreach ($permissions as $permission) {
        DB::table('permission_role')->insert([
            'role_id' => $adminRole->id,
            'permission_id' => $permission->id,
        ]);
    }
}

// Assign limited permissions to the organizer role
$organizerPermissions = [
    'view events',
    'create events',
    'edit events',
    'delete events',
];

if ($organizerRole) {
    foreach ($organizerPermissions as $permissionName) {
        $permission = DB::table('permissions')->where('name', $permissionName)->first();
        if ($permission) {
            DB::table('permission_role')->insert([
                'role_id' => $organizerRole->id,
                'permission_id' => $permission->id,
            ]);
        }
    }
}

    }
}
