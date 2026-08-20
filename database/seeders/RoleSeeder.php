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
                'description' => 'Master Administrator with full system access',
            ],
            [
                'name' => 'Society Admin',
                'slug' => 'society-admin',
                'description' => 'Society Administrator managing society level operations',
            ],
            [
                'name' => 'Security Guard',
                'slug' => 'security-guard',
                'description' => 'Security Guard managing visitor logs and gate entry/exit',
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Society resident user',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
