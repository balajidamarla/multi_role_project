<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use App\Models\SignModel;

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
            ->select('
            projects.*, 
            CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,  
            CONCAT(customers.address1, " ", customers.address2, " ", customers.city_state) AS customer_address,  
            customers.zipcode,
            customers.phone AS contact_info,
            customers.created_at AS customer_created_at,
            users.first_name AS assigned_to_name  
        ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->orderBy('projects.created_at', 'DESC')
            ->findAll();

        return view('admin/projects/index', $data);
    }



    public function view($id)
    {
        $project = $this->projectModel
            ->select('
                projects.*, 
                customers.company_name,
                customers.first_name,
                customers.last_name,
                customers.address1,
                customers.address2,
                customers.city_state,
                customers.zipcode,
                customers.email,
                customers.phone,
                customers.created_at
            ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->where('projects.id', $id)
            ->first();

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project not found.");
        }

        $signs = (new SignModel())
            ->where('project_id', $id)
            ->findAll();

        return view('admin/projects/view', [
            'project' => $project,
            'signs' => $signs
        ]);
    }


    public function create($project_id)
    {
        // Fetch the project data
        $projectModel = new ProjectModel();
        $project = $projectModel->find($project_id);
        $currentUserId = session()->get('user_id');

        // Check if the project exists
        if (!$project) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Project not found.');
        }

        // Fetch only relevant users (admin, superadmin, sales_surveyor, surveyor_lite)
        $userModel = new UserModel();
        $users = $userModel
            ->select('id, first_name, last_name, role')
            ->groupStart()
            ->whereIn('role', ['admin','salessurveyor','Surveyor Lite'])
            ->orWhere('id', $currentUserId)
            ->groupEnd()
            ->findAll();

        // Pass project and users to the view
        return view('salessurveyor/signs/create', [
            'project' => $project,
            'users' => $users
        ]);
    }





    // Controller: ProjectsController.php

    public function addSign()
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
        $signData = [
            'sign_name'        => $this->request->getPost('sign_name'),
            'project_id'       => $this->request->getPost('project_id'),
            'customer_id'      => $this->request->getPost('customer_id'),
            'assigned_to'      => $this->request->getPost('assigned_to'),
            'sign_description' => $this->request->getPost('sign_description'),
            'sign_type'        => $this->request->getPost('sign_type'),
            'address'          => $this->request->getPost('address'),
            'status'           => $this->request->getPost('status'),
            'due_date'         => $this->request->getPost('due_date'),
            'created_by'       => session()->get('user_id'), // Assuming user ID is stored in session
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        // Create an instance of SignModel
        $signModel = new SignModel();

        // Save the sign data to the database
        if ($signModel->save($signData)) {
            // Flash success message and redirect to project detail page
            session()->setFlashdata('success', 'Sign created successfully.');
            return redirect()->to(base_url('admin/projects/view/' . $signData['project_id']));
        } else {
            // Flash error message if saving fails
            session()->setFlashdata('error', 'Failed to create sign.');
            return redirect()->back()->withInput();
        }
    }




    public function delete($id)
    {
        $this->projectModel->delete($id);
        return redirect()->to('/admin/projects')->with('success', 'Project deleted.');
    }
}
