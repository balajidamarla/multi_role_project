<?php

namespace App\Controllers;

class SuperAdminController extends BaseController
{
    public function dashboard()
    {
        $model = new \App\Models\UserModel();

        // Fetch all users with role 'Admin'
        $admins = $model->where('role', 'Admin')->findAll();
        $data['admins'] = $model->findAll(); 

        return view('superadmin/dashboard', ['admins' => $admins]);
    }


    public function addAdminForm()
    {
        return view('superadmin/add_admin'); // form view page
    }

    public function createAdmin()
    {
        $validation = \Config\Services::validation();
        $model = new \App\Models\UserModel();

        $data = $this->request->getPost();

        if (!$this->validate([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->with('error', $validation->getErrors())->withInput();
        }

        $model->save([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => 'Admin', // default role
            'status'   => 'Active'
        ]);

        return redirect()->to('superadmin/dashboard')->with('success', 'Admin registered successfully.');
    }

    public function viewAdmins()
    {
        $model = new \App\Models\UserModel();
        $admins = $model->where('role', 'Admin')->findAll();

        return view('superadmin/view_admins', ['admins' => $admins]);
    }

    public function toggle_status($id)
    {
        $model = new \App\Models\UserModel();
        $admin = $model->find($id);

        if ($admin && $admin['role'] === 'Admin') {
            $newStatus = $admin['status'] === 'Active' ? 'Inactive' : 'Active';
            $model->update($id, ['status' => $newStatus]);
        }

        return redirect()->to(base_url('superadmin/dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}
