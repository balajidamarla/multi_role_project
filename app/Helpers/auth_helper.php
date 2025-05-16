<?php

use App\Models\PermissionModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;

function user_has_permission($userId, $permissionName)
{
    $userModel = new \App\Models\UserModel();
    $rolePermissionModel = new RolePermissionModel();
    $permissionModel = new PermissionModel();

    $user = $userModel->find($userId);
    if (!$user || !$user['role_id']) {
        return false;
    }

    $permission = $permissionModel->where('name', $permissionName)->first();
    if (!$permission) {
        return false;
    }

    return $rolePermissionModel
        ->where('role_id', $user['role_id'])
        ->where('permission_id', $permission['id'])
        ->countAllResults() > 0;
}
