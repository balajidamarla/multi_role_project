<?php
// app/Controllers/ApiController.php
namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\TokenService;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';
class ApiLoginController extends ResourceController
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
        $data = $this->request->getJSON(true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->response->setJSON([
                'error' => 'Email and password are required.'
            ])->setStatusCode(400);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->where('status', 'Active')->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'error' => 'Invalid credentials or inactive account.'
            ])->setStatusCode(401);
        }

        // JWT payload
        $key = getenv('JWT_SECRET');
        $normalizedRole = strtolower(str_replace(' ', '', $user['role']));

        $payload = [
            'iss' => 'multi-role-app',
            'aud' => 'multi-role-app',
            'iat' => time(),
            'exp' => time() + 3600, // expires in 1 hour
            'sub' => $user['id'],
            'email' => $user['email'],
            'role' => $normalizedRole
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        // Success response
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
