<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)
            ->where('status', 'Active')
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            $normalizedRole = strtolower(str_replace(' ', '', $user['role'])); // keep this if needed

            $session->set([
                'user_id'   => $user['id'],
                'email'     => $user['email'],
                'first_name' => $user['first_name'], 
                'last_name'  => $user['last_name'],
                'role'      => strtolower(str_replace(' ', '', $user['role'])), // e.g. "admin"
                'role_id' => $user['role_id'], // store role_id as well
                'logged_in' => true
            ]);

            // Redirect based on role string (optional)
            switch ($normalizedRole) {
                case 'superadmin':
                    return redirect()->to('superadmin/dashboard');
                case 'admin':
                    return redirect()->to('admin/dashboard');
                case 'salessurveyor':
                    return redirect()->to('surveyor/dashboard');
                case 'surveyorlite':
                    return redirect()->to('surveyorlite/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials or inactive account.');
    }


    public function registerForm()
    {
        return view('auth/register'); // or just 'register' if your file is at app/Views/register.php
    }

    public function register()
    {
        $validation = \Config\Services::validation();
        $model = new UserModel();

        $data = $this->request->getPost();

        if (!$this->validate([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required'
        ])) {
            return redirect()->back()->with('error', $validation->getErrors())->withInput();
        }

        $model->save([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'],
            'status'   => 'Active'
        ]);

        return redirect()->to('/login')->with('success', 'Account created successfully. Please login.');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
