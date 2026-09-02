<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $roles = [
            [
                'name' => 'Master Admin',
                'slug' => 'master-admin',
                'description' => 'Master Administrator with full system control and management access',
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator managing society application data and users',
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Standard resident user with personal access to society services',
            ],
            [
                'name' => 'Security Guard',
                'slug' => 'security-guard',
                'description' => 'Security Guard managing visitor entries, gate desk, and security logs',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                [
                    'name' => $role['name'],
                    'description' => $role['description'],
                ]
            );
        }
    }
}
