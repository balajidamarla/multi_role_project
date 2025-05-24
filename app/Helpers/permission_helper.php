<?php

use App\Models\RoleModel;
use App\Models\RolePermissionModel;

if (!function_exists('has_permission')) {
    /**
     * Check if the current logged-in user's role has a specific permission.
     *
     * @param string $permissionName
     * @return bool
     */
    function has_permission(string $permissionName): bool
    {
        $session = session();
        $roleName = strtolower($session->get('role') ?? '');

        if (!$roleName) {
            return false; // No role in session
        }

        // Grant all permissions to admin
        if ($roleName === 'admin') {
            return true;
        }


        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // Get role by name (case-insensitive)
        $role = $roleModel->where('LOWER(name)', $roleName)->first();
        if (!$role) {
            return false;
        }

        // Get permissions linked to the role
        $permissions = $rolePermissionModel->getPermissionsByRoleId($role['id']);
        // var_dump($role);
        foreach ($permissions as $permission) {
            if (strtolower($permission['name']) === strtolower($permissionName)) {
                return true;
            }
        }

        return false;
    }
}
