<?php

use App\Models\RoleModel;
use App\Models\RolePermissionModel;

if (!function_exists('has_permission')) {
    function has_permission(string $permissionName): bool
    {
        $session = session();
        $roleName = strtolower($session->get('role') ?? '');

        if (!$roleName) {
            return false; // no role in session
        }

        // Admin has all permissions
        if ($roleName === 'admin') {
            return true;
        }

        // Roles allowed to inherit only admin-granted permissions
        $restrictedRoles = ['salessurveyor', 'Surveyor Lite'];

        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // Get current role
        $role = $roleModel->where('LOWER(name)', $roleName)->first();
        if (!$role) return false;

        // If role is one of the restricted ones, check if permission exists in both this role and admin
        if (in_array($roleName, $restrictedRoles)) {
            // Get permissions for this role
            $rolePermissions = $rolePermissionModel->getPermissionsByRoleId($role['id']);

            // Get admin permissions
            $adminRole = $roleModel->where('LOWER(name)', 'admin')->first();
            if (!$adminRole) return false;

            $adminPermissions = $rolePermissionModel->getPermissionsByRoleId($adminRole['id']);

            // Convert both permission lists to flat arrays
            $rolePermissionNames = array_column($rolePermissions, 'name');
            $adminPermissionNames = array_column($adminPermissions, 'name');

            // Allow only if permission exists in both
            return in_array($permissionName, $rolePermissionNames) && in_array($permissionName, $adminPermissionNames);
        }

        // For all other roles, check their own permissions only
        $permissions = $rolePermissionModel->getPermissionsByRoleId($role['id']);
        foreach ($permissions as $permission) {
            if ($permission['name'] === $permissionName) {
                return true;
            }
        }

        return false;
    }
}
