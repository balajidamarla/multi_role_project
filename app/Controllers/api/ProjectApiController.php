<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Libraries\TokenService;
use App\Models\ProjectModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require APPPATH . 'ThirdParty/files/vendor/autoload.php';

class ProjectApiController extends ResourceController
{
    protected $ProjectModel;

    public function __construct()
    {
        $this->ProjectModel = new ProjectModel();
    }

    // JWT-protected endpoint to list customers
    public function index()
    {
        $projects = $this->ProjectModel->findAll();

        return $this->respond([
            'status' => 'success',
            'data' => $projects
        ]);
    }
}
