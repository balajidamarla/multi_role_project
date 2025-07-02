<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Libraries\TokenService;
use App\Models\RoleModel;
use App\Models\SignModel;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';

class RoleApiController extends ResourceController
{
    protected $RoleModel;

    public function __construct()
    {
        $this->RoleModel = new RoleModel();
    }

    // JWT-protected endpoint to list customers
    public function index()
    {
        $roles = $this->RoleModel->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $roles
        ]);
    }
}
