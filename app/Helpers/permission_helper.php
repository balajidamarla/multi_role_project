<?php

use App\Models\RoleModel;
use App\Models\RolePermissionModel;

if (!function_exists('has_permission')) {
    /**
     * Check if current logged-in user has a specific permission.
     *
     * @param string $permissionName The permission name to check, e.g. 'edit_role'
     * @return bool True if user has permission, false otherwise.
     */
    function has_permission(string $permissionName): bool
    {
        $session = session();
        $roleName = strtolower($session->get('role') ?? '');

        // Admin shortcut: grant all permissions
        if ($roleName === 'admin') {
            return true;
        }

        // Load models
        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // Find role by name (case-insensitive, adjust if needed)
        $role = $roleModel->where('LOWER(name)', $roleName)->first();

        if (!$role) {
            return false; // role not found
        }

        // Get permissions assigned to this role
        $permissions = $rolePermissionModel->getPermissionsByRoleId($role['id']);

        // Check if the requested permission is among the role's permissions
        foreach ($permissions as $permission) {
            if ($permission['name'] === $permissionName) {
                return true;
            }
        }

        return false;
    }
}
