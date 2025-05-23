<?php

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{

    public function index()
    {
        $session = session();
        $adminId = $session->get('user_id');

        $roleModel = new \App\Models\RoleModel();
        $roles = $roleModel->getRolesByAdmin($adminId);

        $data['roles'] = $roles;

        return view('admin/roles/index', $data);
    }



    public function create()
    {
        $permissionModel = new \App\Models\PermissionModel();

        $adminId = session()->get('user_id'); // Get current admin ID from session

        // Fetch only permissions created by this admin
        $data['permissions'] = $permissionModel
            ->where('created_by', $adminId)
            ->findAll();

        return view('admin/roles/create', $data);
    }


    public function store()
    {
        $roleModel = new RoleModel();
        $rolePermissionModel = new RolePermissionModel();

        // Get current admin ID
        $adminId = session()->get('user_id');

        // Insert new role
        $roleId = $roleModel->insert([
            'name' => $this->request->getPost('role_name'),
            'label' => $this->request->getPost('label_name'),
            'created_by' => $adminId
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

        $adminId = session()->get('user_id');

        // Get the role info
        $role = $roleModel->find($id);

        // Check if role exists and belongs to the current admin
        if (!$role || $role['created_by'] != $adminId) {
            return redirect()->to('admin/roles')->with('error', 'Unauthorized access.');
        }

        // Get all permissions created by this admin
        $permissions = $permissionModel->where('created_by', $adminId)->findAll();

        // Get permission IDs assigned to this role
        $rolePerms = $rolePermissionModel->where('role_id', $id)->findAll();
        $rolePermissions = array_column($rolePerms, 'permission_id');

        // Prepare data for the view
        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ];

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
