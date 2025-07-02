<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Libraries\TokenService;
use App\Models\SignModel;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';

class UsersApiController extends ResourceController
{
    protected $UserModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
    }

    // JWT-protected endpoint to list customers
    public function index()
    {
        $users = $this->UserModel->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $users
        ]);
    }
}
