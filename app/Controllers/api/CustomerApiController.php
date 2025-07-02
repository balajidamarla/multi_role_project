<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Libraries\TokenService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';

class CustomerApiController extends ResourceController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    // JWT-protected endpoint to list customers
    public function index()
    {
        $customers = $this->customerModel->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $customers
        ]);
    }
}
