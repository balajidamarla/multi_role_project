<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    // Display users by role
    public function showRole($roleName)
    {
        $session = session();
        $userModel = new \App\Models\UserModel();

        // Step 1: Check if user is logged in
        $userId = $session->get('user_id'); // Change this if your session uses a different key

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'You must be logged in.');
        }

        // Step 2: Get the user from DB
        $user = $userModel->find($userId);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User not found.");
        }


        // Step 4: Validate role match
        if (strtolower($user['role']) !== strtolower($roleName)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User does not belong to role: $roleName");
        }

        return view('admin/roles/show', [
            'roleName' => $roleName,
            'user' => $user
        ]);
    }



    // Optional: Default user list (e.g., all users)
    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('admin/users/index', ['users' => $users]);
    }

    public function update($id)
    {
        $userModel = new \App\Models\UserModel();

        // Get current user to compare email for unique validation
        $currentUser = $userModel->find($id);
        if (!$currentUser) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $rules = [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
        ];

        // var_dump($data); die;

        try {
            $updated = $userModel->update($id, $data);
            if ($updated === false) {
                return redirect()->back()->withInput()->with('error', 'Failed to update user.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Exception: ' . $e->getMessage());
        }

        return redirect()->to('/admin/roles/' . strtolower($currentUser['role']))->with('success', 'Profile updated successfully.');
    }
}
