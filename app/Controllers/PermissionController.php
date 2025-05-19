<?php

namespace App\Controllers;

use App\Models\PermissionModel;
use CodeIgniter\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        $permissionModel = new PermissionModel();
        $data['permissions'] = $permissionModel->findAll();
        return view('admin/permissions/index', $data);
    }

    public function create()
    {
        return view('admin/permissions/create');
    }

    public function store()
    {
        $permissionModel = new PermissionModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'  => 'required|is_unique[permissions.name]',
            'label' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $validation->getErrors()));
        }

        $permissionModel->insert([
            'name'  => $this->request->getPost('name'),
            'label' => $this->request->getPost('label'),
        ]);

        return redirect()->to('admin/permissions')->with('success', 'Permission added successfully.');
    }

    public function edit($id)
    {
        $permissionModel = new PermissionModel();
        $data['permission'] = $permissionModel->find($id);
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
