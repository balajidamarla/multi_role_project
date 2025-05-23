<?php

namespace App\Controllers;

use App\Models\PermissionModel;
use CodeIgniter\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        $session = session();
        $adminId = $session->get('user_id');

        $permissionModel = new \App\Models\PermissionModel();

        $data['permissions'] = $permissionModel->getPermissionsByAdmin($adminId, 5);
        $data['pager'] = $permissionModel->getPager();

        return view('admin/permissions/index', $data);
    }


    public function create()
    {
        return view('admin/permissions/create');
    }

    public function store()
    {
        $permissionModel = new \App\Models\PermissionModel();
        $adminId = session()->get('user_id');

        $name = $this->request->getPost('name');
        $label = $this->request->getPost('label');

        // Validate inputs
        if (!$name || !$label) {
            return redirect()->back()->withInput()->with('error', 'Name and label are required.');
        }

        // Check uniqueness per admin
        $existing = $permissionModel
            ->where('name', $name)
            ->where('created_by', $adminId)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'You already created this permission name.');
        }

        // Insert
        $permissionModel->insert([
            'name'       => $name,
            'label'      => $label,
            'created_by' => $adminId
        ]);

        return redirect()->to('admin/permissions')->with('success', 'Permission added successfully.');
    }


    public function edit($id)
    {
        $permissionModel = new PermissionModel();
        $adminId = session()->get('user_id'); // Get currently logged-in admin ID

        // Fetch the permission
        $permission = $permissionModel->find($id);

        // Check if permission exists and belongs to the current admin
        if (!$permission || $permission['created_by'] != $adminId) {
            return redirect()->to('admin/permissions')->with('error', 'Unauthorized access.');
        }

        $data['permission'] = $permission;
        return view('admin/permissions/edit', $data);
    }


    public function update($id)
    {
        $permissionModel = new PermissionModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'  => 'required',
            'label' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        $permissionModel->update($id, [
            'name'  => $this->request->getPost('name'),
            'label' => $this->request->getPost('label'),
        ]);

        return redirect()->to('admin/permissions')->with('success', 'Permission updated successfully.');
    }

    public function delete($id)
    {
        $permissionModel = new PermissionModel();
        $permissionModel->delete($id);
        return redirect()->to('admin/permissions')->with('success', 'Permission deleted successfully.');
    }
}
