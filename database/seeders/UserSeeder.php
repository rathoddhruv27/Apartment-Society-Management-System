<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masterRole = Role::where('slug', 'master-admin')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();
        $guardRole = Role::where('slug', 'security-guard')->first();

        $users = [
            [
                'name' => 'Master Administrator',
                'email' => 'masteradmin@asms.com',
                'phone' => '+19990000001',
                'password' => Hash::make('password'),
                'role_id' => $masterRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Society Admin',
                'email' => 'admin@asms.com',
                'phone' => '+19990000002',
                'password' => Hash::make('password'),
                'role_id' => $adminRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'John Resident',
                'email' => 'user@asms.com',
                'phone' => '+19990000003',
                'password' => Hash::make('password'),
                'role_id' => $userRole?->id,
                'status' => 'active',
            ],
            [
                'name' => 'Gate Officer Alex',
                'email' => 'guard@asms.com',
                'phone' => '+19990000004',
                'password' => Hash::make('password'),
                'role_id' => $guardRole?->id,
                'status' => 'active',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
