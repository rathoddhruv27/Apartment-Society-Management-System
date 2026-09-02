<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAccessControlTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_database_seeders_create_the_four_required_roles()
    {
        $this->assertDatabaseHas('roles', ['slug' => 'master-admin']);
        $this->assertDatabaseHas('roles', ['slug' => 'admin']);
        $this->assertDatabaseHas('roles', ['slug' => 'user']);
        $this->assertDatabaseHas('roles', ['slug' => 'security-guard']);
    }

    public function test_user_model_role_helper_methods_work_correctly()
    {
        $masterUser = User::whereHas('role', fn ($q) => $q->where('slug', 'master-admin'))->first();
        $adminUser = User::whereHas('role', fn ($q) => $q->where('slug', 'admin'))->first();
        $residentUser = User::whereHas('role', fn ($q) => $q->where('slug', 'user'))->first();
        $guardUser = User::whereHas('role', fn ($q) => $q->where('slug', 'security-guard'))->first();

        $this->assertTrue($masterUser->isMasterAdmin());
        $this->assertTrue($adminUser->isAdmin());
        $this->assertTrue($residentUser->isUser());
        $this->assertTrue($guardUser->isSecurityGuard());

        $this->assertTrue($masterUser->hasRole('master-admin'));
        $this->assertTrue($adminUser->hasRole('admin'));
        $this->assertTrue($guardUser->hasRole('security-guard'));
    }

    public function test_master_admin_possesses_all_permissions()
    {
        $masterUser = User::whereHas('role', fn ($q) => $q->where('slug', 'master-admin'))->first();

        $this->assertTrue($masterUser->hasPermission('manage-roles'));
        $this->assertTrue($masterUser->hasPermission('manage-permissions'));
        $this->assertTrue($masterUser->hasPermission('view-users'));
        $this->assertTrue($masterUser->hasPermission('checkin-visitors'));
    }

    public function test_security_guard_has_access_to_visitor_desk_only_and_denied_user_management()
    {
        $guardUser = User::whereHas('role', fn ($q) => $q->where('slug', 'security-guard'))->first();

        $this->assertTrue($guardUser->hasPermission('view-visitors'));
        $this->assertFalse($guardUser->hasPermission('manage-roles'));
        $this->assertFalse($guardUser->hasPermission('create-users'));

        // Guard can access visitor desk
        $response = $this->actingAs($guardUser)->get(route('visitors.index'));
        $response->assertStatus(200);

        // Guard is forbidden from accessing roles and user management
        $responseRoles = $this->actingAs($guardUser)->get(route('roles.index'));
        $responseRoles->assertStatus(403);

        $responseUsers = $this->actingAs($guardUser)->get(route('users.index'));
        $responseUsers->assertStatus(403);
    }

    public function test_admin_can_access_user_management_and_visitor_desk_but_denied_roles()
    {
        $adminUser = User::whereHas('role', fn ($q) => $q->where('slug', 'admin'))->first();

        // Admin can access users
        $responseUsers = $this->actingAs($adminUser)->get(route('users.index'));
        $responseUsers->assertStatus(200);

        // Admin can access visitors
        $responseVisitors = $this->actingAs($adminUser)->get(route('visitors.index'));
        $responseVisitors->assertStatus(200);

        // Admin denied master-admin roles page
        $responseRoles = $this->actingAs($adminUser)->get(route('roles.index'));
        $responseRoles->assertStatus(403);
    }

    public function test_master_admin_can_access_all_module_routes()
    {
        $masterUser = User::whereHas('role', fn ($q) => $q->where('slug', 'master-admin'))->first();

        $this->actingAs($masterUser)->get(route('dashboard'))->assertStatus(200);
        $this->actingAs($masterUser)->get(route('roles.index'))->assertStatus(200);
        $this->actingAs($masterUser)->get(route('users.index'))->assertStatus(200);
        $this->actingAs($masterUser)->get(route('visitors.index'))->assertStatus(200);
        $this->actingAs($masterUser)->get(route('complaints.index'))->assertStatus(200);
    }

    public function test_guest_users_are_redirected_to_login()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }
}
