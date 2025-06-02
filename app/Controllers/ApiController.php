<?php
// app/Controllers/ApiController.php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\TokenService;

class ApiController extends ResourceController
{
    public function protectedData()
    {
        $userId = TokenService::getUserId();
        $email = TokenService::getEmail();

        return $this->respond([
            'message' => 'Protected data accessed!',
            'user_id' => $userId,
            'email' => $email,
        ]);
    }
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

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
}
