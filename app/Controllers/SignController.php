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
    protected $UserModel;
    protected $db;

    public function __construct()
    {
        $this->signModel = new SignModel();
        $this->UserModel = new UserModel();
        // Load the database
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $currentAdminId = session()->get('user_id'); // Get the currently logged-in admin's ID

        // Fetch all signs with related customer, project, and assigned user details
        $signs = $this->signModel
            ->select('
            signs.*, 
            customers.company_name AS customer_name,
            projects.name AS project_name,
            assigned_user.first_name AS assigned_first_name,
            assigned_user.last_name AS assigned_last_name
        ')
            ->join('customers', 'customers.id = signs.customer_id', 'left')
            ->join('projects', 'projects.id = signs.project_id', 'left')
            ->join('users as assigned_user', 'assigned_user.id = signs.assigned_to', 'left')
            ->orderBy('signs.created_at', 'DESC')
            ->findAll();

        // Fetch users who can be assigned to a sign: sales_surveyor, surveyor_lite, and the current admin
        $users = $this->UserModel
            ->select('id, first_name, last_name, role')
            ->groupStart()
            ->whereIn('role', ['Sales Surveyor', 'Surveyor Lite'])
            ->orWhere('id', $currentAdminId)
            ->groupEnd()
            ->findAll();

        // Pass the signs and assignable users to the view
        return view('admin/signs/index', [
            'signs' => $signs,
            'users' => $users,
        ]);
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

    public function showAssignedSigns($projectId)
    {
        $signModel = new SignModel();
        $signs = $signModel->getSignsWithDetails($projectId);

        // Pass data to the view
        return view('admin/signs/index', [
            'signs' => $signs,
        ]);
    }



    public function updateAssignment($signId)
    {
        $newAssignedTo = $this->request->getPost('assigned_to');

        if ($signId && $newAssignedTo) {
            $this->signModel->update($signId, ['assigned_to' => $newAssignedTo]);

            return redirect()->back()->with('success', 'Sign assignment updated.');
        }

        return redirect()->back()->with('error', 'Invalid data provided.');
    }

    public function edit($id)
    {
        $signModel = new SignModel();
        $userModel = new UserModel();

        $sign = $signModel->find($id); // returns array by default

        if (!$sign) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sign not found');
        }

        $users = $userModel->findAll(); // or filter as needed

        return view('admin/signs/edit', [
            'sign' => $sign,
            'users' => $users
        ]);
    }


    public function update($id)
    {
        $signModel = new SignModel();
        $sign = $signModel->find($id);

        if (!$sign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Sign not found.");
        }

        $signData = [
            'sign_name'        => $this->request->getPost('sign_name'),
            'sign_description' => $this->request->getPost('sign_description'),
            'sign_type'        => $this->request->getPost('sign_type'),
            'assigned_to'      => $this->request->getPost('assigned_to'),
            'progress'           => $this->request->getPost('progre'),
            'due_date'         => $this->request->getPost('due_date'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        $signModel->update($id, $signData);

        session()->setFlashdata('success', 'Sign updated successfully.');
        return redirect()->to(base_url('admin/projects/view/' . $sign['project_id']));
    }
}
