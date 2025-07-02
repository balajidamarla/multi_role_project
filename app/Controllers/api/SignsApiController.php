<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Libraries\TokenService;
use App\Models\SignModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';

class SignsApiController extends ResourceController
{
    protected $SignModel;

    public function __construct()
    {
        $this->SignModel = new SignModel();
    }

    // JWT-protected endpoint to list customers
    public function index()
    {
        $signs = $this->SignModel->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $signs
        ]);
    }
}
