<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Libraries\TokenService;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\SignModel;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';

class PermissionsApiController extends ResourceController
{
    protected $PermissionModel;

    public function __construct()
    {
        $this->PermissionModel = new PermissionModel();
    }

    // JWT-protected endpoint to list customers
    public function index()
    {
        $permissions = $this->PermissionModel->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $permissions
        ]);
    }
}
