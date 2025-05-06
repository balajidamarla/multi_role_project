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
        // Query to fetch signs along with customer info, project name, and assigned user
        $builder = $this->db->table('signs');
        $builder->select('signs.*, customers.company_name AS customer_name, projects.name AS project_name, users.first_name, users.last_name');
        $builder->join('customers', 'signs.customer_id = customers.id', 'left'); // Join customers using customer_id
        $builder->join('projects', 'signs.project_id = projects.id', 'left'); // Join projects to get the project name
        $builder->join('users', 'signs.assigned_to = users.id', 'left'); // Join users to get the assigned person's name
        $builder->where('signs.project_id', $projectId); // Filter by the project_id

        // Execute query and retrieve results
        $signs = $builder->get()->getResultArray();

        // Debug output to check the structure of the result
        echo '<pre>';
        print_r($signs); // This will print out the structure of the $signs array
        echo '</pre>';

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
}
