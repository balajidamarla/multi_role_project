<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\SignModel;
use App\Models\UserModel;



class SurveyorController extends BaseController
{
    protected $projectModel;
    protected $userModel;


    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        $this->userModel = new UserModel();
    }
    public function dashboard()
    {
        return view('salessurveyor/dashboard');
    }

    public function getIndex()
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

        return view('salessurveyor/projects/index', $data);
    }

    // Display all customers
    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->orderBy('created_at', 'DESC')->findAll();

        return view('salessurveyor/customers/index', ['customers' => $customers]);
    }
    public function manageCustomers()
    {
        $model = new CustomerModel();
        $data['customers'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('salessurveyor/manage_customers', $data);
    }

    // Show specific customer details
    public function show($id)
    {
        $customerModel = new CustomerModel();
        $projectModel = new ProjectModel();
        $signModel = new SignModel();

        $customer = $customerModel->find($id);
        if (!$customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Customer not found.");
        }

        // Get all projects related to the customer
        $projects = $projectModel->where('customer_id', $id)->findAll();
        $projectIds = array_column($projects, 'id');

        // Count signs (tasks) for those projects
        $signCount = 0;
        if (!empty($projectIds)) {
            $signCount = $signModel->whereIn('project_id', $projectIds)->countAllResults();
        }

        return view('salessurveyor/customers/show', [
            'customer' => $customer,
            'signCount' => $signCount
        ]);
    }

    public function addCustomerForm()
    {
        return view('salessurveyor/add_customer');
    }

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
            return redirect()->to(base_url('salessurveyor/projects/view/' . $signData['project_id']));
        } else {
            // Flash error message if saving fails
            session()->setFlashdata('error', 'Failed to create sign.');
            return redirect()->back()->withInput();
        }
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
            
        if (!isset($project)) {
            echo "Project data not available.";
            return;
        }

        return view('salessurveyor/projects/view', [
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

        // Fetch only relevant users (salessurveyor)
        $userModel = new UserModel();
        $users = $userModel
            ->select('id, first_name, last_name, role')
            ->groupStart()
            ->whereIn('role', ['Surveyor Lite'])
            ->orWhere('id', $currentUserId)
            ->groupEnd()
            ->findAll();

        // Pass project and users to the view
        return view('salessurveyor/signs/create', [
            'project' => $project,
            'users' => $users
        ]);
    }
}
