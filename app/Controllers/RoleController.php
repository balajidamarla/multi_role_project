<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{

    public function index()
    {
        $roleModel = new \App\Models\RoleModel();
        $rolePermissionModel = new \App\Models\RolePermissionModel();

        $roles = $roleModel->findAll();

        foreach ($roles as &$role) {
            $permissions = $rolePermissionModel->getPermissionsByRoleId($role['id']);
            $role['permissions'] = implode(', ', array_column($permissions, 'name'));
        }

        $data['roles'] = $roles;

        return view('admin/roles/index', $data);
    }



    public function create()
    {
        $permissionModel = new PermissionModel();
        $data['permissions'] = $permissionModel->findAll();

        return view('admin/roles/create', $data);
    }

    public function store()
    {
        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // Insert new role
        $roleId = $roleModel->insert([
            'name' => $this->request->getPost('role_name')
        ]);

        // Get selected permissions
        $permissions = $this->request->getPost('permissions') ?? [];

        // Insert role-permission relations
        foreach ($permissions as $permId) {
            $rolePermissionModel->insert([
                'role_id' => $roleId,
                'permission_id' => $permId
            ]);
        }

        return redirect()->to('admin/roles')->with('success', 'Role created successfully!');
    }
    public function edit($id)
    {
        $roleModel = new RoleModel();
        $permissionModel = new PermissionModel();
        $rolePermissionModel = new RolePermissionModel();

        // Get the role info
        $data['role'] = $roleModel->find($id);

        // Get all permissions
        $data['permissions'] = $permissionModel->findAll();

        // Get permission IDs assigned to this role
        $rolePerms = $rolePermissionModel->where('role_id', $id)->findAll();
        $data['rolePermissions'] = array_column($rolePerms, 'permission_id');

        return view('admin/roles/edit', $data);
    }

    public function update($id)
    {
        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        $validation = \Config\Services::validation();

        $roleName = $this->request->getPost('role_name');
        $permissions = $this->request->getPost('permissions') ?? [];

        // Validate role name (if editable)
        $validation->setRules([
            'role_name' => 'required|min_length[3]|max_length[50]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Validation failed, redirect back with errors and old input
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        // Update role name (if input present)
        if ($roleName) {
            $roleModel->update($id, ['name' => $roleName]);
        }

        // Update permissions
        $rolePermissionModel->where('role_id', $id)->delete();
        foreach ($permissions as $permId) {
            $rolePermissionModel->insert([
                'role_id' => $id,
                'permission_id' => $permId
            ]);
        }

        return redirect()->to('admin/roles')->with('success', 'Role updated successfully!');
    }


    public function delete($id)
    {
        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // Delete related permissions first
        $rolePermissionModel->where('role_id', $id)->delete();

        // Delete role
        $roleModel->delete($id);

        return redirect()->to('admin/roles')->with('success', 'Role deleted successfully!');
    }
}
