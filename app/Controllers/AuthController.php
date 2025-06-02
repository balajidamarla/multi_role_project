<?php

namespace App\Controllers;

use App\Models\UserModel;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


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
            $normalizedRole = strtolower(str_replace(' ', '', $user['role']));

            // Store session data (for web use)
            $session->set([
                'user_id'    => $user['id'],
                'email'      => $user['email'],
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'role'       => $normalizedRole,
                'role_id'    => $user['role_id'],
                'logged_in'  => true
            ]);

            // Optional: Only for admin store separately
            if ($normalizedRole === 'admin') {
                $session->set('user_id', $user['id']);
            }

            // If it's an API request (e.g., Accept: application/json)
            if ($this->request->isAJAX() || $this->request->getHeaderLine('Accept') === 'application/json') {
                $key = getenv('JWT_SECRET');
                $payload = [
                    'iss' => 'your-app-name',
                    'aud' => 'your-app-name',
                    'iat' => time(),
                    'exp' => time() + 3600, // 1 hour
                    'sub' => $user['id'],
                    'email' => $user['email'],
                    'role'  => $normalizedRole
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');

                return $this->response->setJSON([
                    'token' => $jwt,
                    'user'  => [
                        'id'    => $user['id'],
                        'email' => $user['email'],
                        'name'  => $user['first_name'] . ' ' . $user['last_name'],
                        'role'  => $normalizedRole
                    ]
                ]);
            }

            // For web request: redirect by role
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

        // Handle invalid login
        if ($this->request->isAJAX() || $this->request->getHeaderLine('Accept') === 'application/json') {
            return $this->response->setJSON(['error' => 'Invalid credentials or inactive account'])->setStatusCode(401);
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
