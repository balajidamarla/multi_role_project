<?php

use App\Models\RoleModel;
use App\Models\RolePermissionModel;

if (!function_exists('has_permission')) {
    function has_permission(string $permissionName): bool
    {
        $session = session();
        $roleName = strtolower($session->get('role') ?? '');

        // echo "Checking permission: " . $permissionName . " for role: " . $roleName;
        // exit;

        if (!$roleName) {
            return false; // no role in session
        }

        // Admin has all permissions
        if ($roleName === 'admin') {
            return true;
        }



        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // // Get current role
        $role = $roleModel->where('LOWER(name)', $roleName)->first();
        if (!$role) return false;

        $permissions = $rolePermissionModel->getPermissionsByRoleId($role['id']);
        foreach ($permissions as $permission) {
            
            if ($permission['name'] === strtolower($permissionName)) {
                return true;
            }
        }

        return false;
    }
}
