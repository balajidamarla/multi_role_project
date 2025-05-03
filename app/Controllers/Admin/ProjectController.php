<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\CustomerModel;
use App\Models\UserModel;

class ProjectController extends BaseController
{
    protected $projectModel;
    protected $customerModel;
    protected $userModel;

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->customerModel = new CustomerModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['projects'] = $this->projectModel
            ->select('projects.*, projects.name as customer_name, users.first_name as assigned_to_name')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->orderBy('projects.created_at', 'DESC')
            ->findAll();

        return view('admin/projects/index', $data);
    }

    // Controller: ProjectsController.php

    public function create()
    {
        // Fetch all customers
        $customers = $this->customerModel->findAll();

        // Add a 'name' field by concatenating first_name and last_name
        foreach ($customers as &$customer) {
            $customer['name'] = $customer['first_name'] . ' ' . $customer['last_name'];
        }

        // Fetch users with the roles 'sales_surveyor' and 'surveyor_lite' directly from users table
        $data['customers'] = $customers;
        $data['users'] = $this->userModel
            ->select('id, first_name, last_name')
            ->whereIn('role', ['Sales Surveyor', 'Surveyor Lite']) // Only these roles
            ->findAll();

        // Create full name for users
        foreach ($data['users'] as &$user) {
            $user['name'] = $user['first_name'] . ' ' . $user['last_name'];
        }

        // Pass data to the view
        return view('admin/projects/create', $data);
    }



    // Controller: ProjectsController.php

    public function store()
    {
        // Get the input data from the form
        $projectData = [
            'customer_id' => $this->request->getPost('customer_id'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
            'assigned_to' => $this->request->getPost('assigned_to'),
            'created_by'  => session()->get('user_id'), // Get from session
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        // Save the project data to the database
        if ($this->projectModel->save($projectData)) {
            return redirect()->to('/admin/projects')->with('success', 'Project created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create project.');
        }
    }



    public function delete($id)
    {
        $this->projectModel->delete($id);
        return redirect()->to('/admin/projects')->with('success', 'Project deleted.');
    }
}
