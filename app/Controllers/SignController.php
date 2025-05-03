<?php
// Controller: Admin/SignController.php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SignModel;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\UserModel;

class SignController extends BaseController
{
    protected $signModel;

    public function __construct()
    {
        $this->signModel = new SignModel();
    }

    public function index()
    {
        $data['signs'] = $this->signModel->findAll();
        return view('admin/signs/index', $data);
    }


    public function create()
    {
        $projectModel = new ProjectModel();
        $customerModel = new CustomerModel();
        $userModel = new UserModel();

        $data['projects'] = $projectModel->findAll();
        $data['customers'] = $customerModel->findAll();
        $data['surveyors'] = $userModel
            ->whereIn('role', ['Sales Surveyor', 'Surveyor Lite'])
            ->findAll();

        return view('admin/signs/create', $data);
    }


    public function store()
    {
        $this->signModel->save([
            'sign_name'        => $this->request->getPost('sign_name'),
            'project_id'       => $this->request->getPost('project_id'),
            'customer_id'      => $this->request->getPost('customer_id'),
            'assigned_to'      => $this->request->getPost('assigned_to'),
            'sign_description' => $this->request->getPost('sign_description'),
            'sign_type'        => $this->request->getPost('sign_type'),
            'address'          => $this->request->getPost('address'),
            'due_date'         => $this->request->getPost('due_date'),
            'progress'         => $this->request->getPost('progress'),
            'created_by'       => session()->get('user_id'),
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/signs')->with('success', 'Sign added successfully.');
    }

    public function delete($id)
    {
        $this->signModel->delete($id);
        return redirect()->to('/admin/signs')->with('success', 'Sign deleted.');
    }
    public function test()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => false, 'message' => $this->validator->getErrors()]);
        }
        $json = $this->request->getJSON();
        $name = $json->name;
        $email = $json->email;
        $data = ['name' => $name, 'email' => $email];
        return $this->response
            ->setStatusCode(403)
            ->setJSON(['status' => true, 'message' => "success", 'data' => $data]);
    }
}
