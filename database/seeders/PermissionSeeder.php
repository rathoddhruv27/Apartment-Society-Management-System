<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        \DB::table('permission_role')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            // System & Roles
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'module' => 'System', 'description' => 'Create, edit, and delete system roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'module' => 'System', 'description' => 'Assign and configure permissions'],
            ['name' => 'System Settings', 'slug' => 'system-settings', 'module' => 'System', 'description' => 'Manage core system settings and logs'],

            // Users
            ['name' => 'View Users', 'slug' => 'view-users', 'module' => 'Users', 'description' => 'View all users in the society'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'module' => 'Users', 'description' => 'Add new users to the society'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'module' => 'Users', 'description' => 'Update existing user profiles and status'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'module' => 'Users', 'description' => 'Delete users from the system'],

            // Buildings & Apartments
            ['name' => 'View Buildings', 'slug' => 'view-buildings', 'module' => 'Buildings', 'description' => 'View society buildings'],
            ['name' => 'Manage Buildings', 'slug' => 'manage-buildings', 'module' => 'Buildings', 'description' => 'Create and modify building data'],
            ['name' => 'View Apartments', 'slug' => 'view-apartments', 'module' => 'Apartments', 'description' => 'View society apartments'],
            ['name' => 'Manage Apartments', 'slug' => 'manage-apartments', 'module' => 'Apartments', 'description' => 'Manage apartment assignments and details'],

            // Vehicles
            ['name' => 'View Vehicles', 'slug' => 'view-vehicles', 'module' => 'Vehicles', 'description' => 'View all registered vehicles for security verification'],
            ['name' => 'Manage Vehicles', 'slug' => 'manage-vehicles', 'module' => 'Vehicles', 'description' => 'Manage all society vehicle records'],
            ['name' => 'View Own Vehicles', 'slug' => 'view-own-vehicles', 'module' => 'Vehicles', 'description' => 'View resident personal vehicles'],
            ['name' => 'Manage Own Vehicles', 'slug' => 'manage-own-vehicles', 'module' => 'Vehicles', 'description' => 'Add or edit resident personal vehicles'],

            // Family Members
            ['name' => 'View Family Members', 'slug' => 'view-family', 'module' => 'Family', 'description' => 'View society family records'],
            ['name' => 'Manage Family Members', 'slug' => 'manage-family', 'module' => 'Family', 'description' => 'Manage all family member records'],
            ['name' => 'View Own Family Members', 'slug' => 'view-own-family', 'module' => 'Family', 'description' => 'View personal family members'],
            ['name' => 'Manage Own Family Members', 'slug' => 'manage-own-family', 'module' => 'Family', 'description' => 'Add/edit personal family members'],

            // Complaints
            ['name' => 'View All Complaints', 'slug' => 'view-complaints', 'module' => 'Complaints', 'description' => 'View all resident complaints'],
            ['name' => 'Manage Complaints', 'slug' => 'manage-complaints', 'module' => 'Complaints', 'description' => 'Update status and assign complaints'],
            ['name' => 'View Own Complaints', 'slug' => 'view-own-complaints', 'module' => 'Complaints', 'description' => 'View submitted complaints'],
            ['name' => 'Create Complaints', 'slug' => 'create-complaints', 'module' => 'Complaints', 'description' => 'Submit new complaints'],

            // Visitors
            ['name' => 'View Visitors', 'slug' => 'view-visitors', 'module' => 'Visitors', 'description' => 'View gate visitor log entries'],
            ['name' => 'Manage Visitors', 'slug' => 'manage-visitors', 'module' => 'Visitors', 'description' => 'Manage gate entry desk records'],
            ['name' => 'Check-in Visitors', 'slug' => 'checkin-visitors', 'module' => 'Visitors', 'description' => 'Log visitor arrivals at gate'],
            ['name' => 'Check-out Visitors', 'slug' => 'checkout-visitors', 'module' => 'Visitors', 'description' => 'Log visitor departures at gate'],
            ['name' => 'View Own Visitors', 'slug' => 'view-own-visitors', 'module' => 'Visitors', 'description' => 'View personal visitor invites'],
            ['name' => 'Create Visitor Passes', 'slug' => 'create-visitors', 'module' => 'Visitors', 'description' => 'Generate pre-approved visitor passes'],

            // Notices
            ['name' => 'View Notices', 'slug' => 'view-notices', 'module' => 'Notices', 'description' => 'Read society bulletin notices'],
            ['name' => 'Manage Notices', 'slug' => 'manage-notices', 'module' => 'Notices', 'description' => 'Publish and edit society notices'],

            // Emergency Contacts
            ['name' => 'View Emergency Contacts', 'slug' => 'view-emergency-contacts', 'module' => 'Emergency', 'description' => 'View emergency numbers and services'],
            ['name' => 'Manage Emergency Contacts', 'slug' => 'manage-emergency-contacts', 'module' => 'Emergency', 'description' => 'Maintain emergency phone directory'],
        ];

        $createdPermissions = [];
        foreach ($permissions as $perm) {
            $createdPermissions[$perm['slug']] = Permission::create($perm);
        }

        // Attach permissions to roles
        $masterAdminRole = Role::where('slug', 'master-admin')->first();
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();
        $guardRole = Role::where('slug', 'security-guard')->first();

        // Master Admin gets all permissions
        if ($masterAdminRole) {
            $masterAdminRole->permissions()->sync(array_column($createdPermissions, 'id'));
        }

        // Admin permissions
        if ($adminRole) {
            $adminPermissionSlugs = [
                'view-users', 'create-users', 'edit-users', 'delete-users',
                'view-buildings', 'manage-buildings',
                'view-apartments', 'manage-apartments',
                'view-vehicles', 'manage-vehicles', 'view-own-vehicles', 'manage-own-vehicles',
                'view-family', 'manage-family', 'view-own-family', 'manage-own-family',
                'view-complaints', 'manage-complaints', 'view-own-complaints', 'create-complaints',
                'view-visitors', 'manage-visitors', 'checkin-visitors', 'checkout-visitors', 'view-own-visitors', 'create-visitors',
                'view-notices', 'manage-notices',
                'view-emergency-contacts', 'manage-emergency-contacts',
            ];
            $ids = Permission::whereIn('slug', $adminPermissionSlugs)->pluck('id');
            $adminRole->permissions()->sync($ids);
        }

        // Resident User permissions
        if ($userRole) {
            $userPermissionSlugs = [
                'view-buildings', 'view-apartments',
                'view-own-vehicles', 'manage-own-vehicles',
                'view-own-family', 'manage-own-family',
                'view-own-complaints', 'create-complaints',
                'view-own-visitors', 'create-visitors',
                'view-notices',
                'view-emergency-contacts',
            ];
            $ids = Permission::whereIn('slug', $userPermissionSlugs)->pluck('id');
            $userRole->permissions()->sync($ids);
        }

        // Security Guard permissions
        if ($guardRole) {
            $guardPermissionSlugs = [
                'view-visitors', 'manage-visitors', 'checkin-visitors', 'checkout-visitors',
                'view-vehicles',
                'view-notices',
                'view-emergency-contacts',
            ];
            $ids = Permission::whereIn('slug', $guardPermissionSlugs)->pluck('id');
            $guardRole->permissions()->sync($ids);
        }
    }
}
