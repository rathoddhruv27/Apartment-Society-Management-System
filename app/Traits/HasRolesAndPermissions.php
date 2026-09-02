<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRolesAndPermissions
{
    /**
     * Relationship to Role model.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has a given role by slug.
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole(string|array $roles): bool
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->slug, $roles, true);
        }

        return $this->role->slug === $roles;
    }

    /**
     * Check if user has any of the given roles.
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Check if user has a given permission by slug.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        // Master Admin automatically gets full system access
        if ($this->isMasterAdmin()) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()->where('slug', $permission)->exists();
    }

    /**
     * Check if user has any of the given permissions.
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isMasterAdmin()) {
            return true;
        }

        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()->whereIn('slug', $permissions)->exists();
    }

    /**
     * Check if user is Master Admin.
     */
    public function isMasterAdmin(): bool
    {
        return $this->hasRole('master-admin');
    }

    /**
     * Check if user is Admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is Resident User.
     */
    public function isUser(): bool
    {
        return $this->hasRole('user');
    }

    /**
     * Check if user is Security Guard.
     */
    public function isSecurityGuard(): bool
    {
        return $this->hasRole('security-guard');
    }

    /**
     * Check if user is Admin or Master Admin.
     */
    public function isAdminOrMaster(): bool
    {
        return $this->hasAnyRole(['master-admin', 'admin']);
    }
}
