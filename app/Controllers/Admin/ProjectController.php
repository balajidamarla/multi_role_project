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
        $projectModel = new \App\Models\ProjectModel();
        $signModel = new \App\Models\SignModel();
        $userModel = new \App\Models\UserModel();

        // Get all projects
        $data['projects'] = $projectModel->projects();

        // Get current user's role
        $currentUserId = session()->get('user_id');
        $user = $userModel->find($currentUserId);
        $data['role'] = $user['role'];

        // Fetch all signs and group them by project_id
        $signs = $signModel->findAll();
        $signsByProject = [];

        foreach ($signs as $sign) {
            $projectId = $sign['project_id'];
            if (!isset($signsByProject[$projectId])) {
                $signsByProject[$projectId] = [];
            }
            $signsByProject[$projectId][] = $sign;
        }

        // Pass grouped signs to the view
        $data['signsByProject'] = $signsByProject;

        return view('admin/projects/index', $data);
    }


    public function view($id)
    {
        // Use the getProjectById method to fetch the project by ID
        $project = $this->projectModel->getProjectById($id);

        // Check if a project was found
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project not found.");
        }
        // Fetch the current user's role (example using session)
        $role = session()->get('role');  // Assuming 'role' is stored in the session


        // Fetch related signs for the project
        $signs = (new SignModel())
            ->where('project_id', $id)
            ->findAll();

        // Return the view with the project and signs data
        return view('admin/projects/view', [
            'project' => $project,
            'signs' => $signs,
            'role' => $role
        ]);
    }

    // Create Project
    public function create()
    {
        $projectModel = new ProjectModel();
        $userModel = new UserModel();

        $data['projects'] = $projectModel->projects(); // this fetches project + customer info
        $data['surveyors'] = $userModel
            ->whereIn('role', ['salessurveyor', 'Surveyor Lite'])
            ->findAll();

        return view('admin/signs/create', $data);
    }




    // Add Sign
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

    // Store the sign
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

        $userRole = session()->get('user_role'); // Get the role from session

        // Check if user is allowed to add signs
        // if ($userRole !== 'admin' && $userRole !== 'salessurveyor') {
        //     throw new \CodeIgniter\Exceptions\ForbiddenException("You don't have permission to add signs.");
        // }

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

    // Delete Project
    public function delete($id)
    {
        $this->projectModel->delete($id);
        return redirect()->to('/admin/projects')->with('success', 'Project deleted.');
    }

    public function edit($id)
    {
        $projectModel = new \App\Models\ProjectModel();
        $customerModel = new \App\Models\CustomerModel();
        $userModel = new \App\Models\UserModel();

        // Fetch project by ID
        $project = $projectModel->where('id', $id)->get()->getFirstRow('array');


        if (!$project) {
            return redirect()->to('/projects')->with('error', 'Project not found.');
        }

        // Fetch assigned users
        $users = $userModel->findAll();

        // Fetch customer based on customer_id in project
        $customer = $customerModel->find($project['customer_id']);

        // Add full customer name to project array
        $project['customer_name'] = $customer['first_name'] . ' ' . $customer['last_name'];

        return view('admin/projects/edit', [
            'project' => $project,
            'users' => $users
        ]);
    }



    public function update($id)
    {
        $projectModel = new \App\Models\ProjectModel();

        $data = [
            'name'        => $this->request->getPost('name'),
            'status'      => $this->request->getPost('status'),
            'assigned_to' => $this->request->getPost('assigned_to'),
            'due_date'    => $this->request->getPost('due_date'),
        ];

        if ($projectModel->update($id, $data)) {
            return redirect()->to('admin/projects')->with('success', 'Project updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update project.');
        }
    }

    public function deleteProject($id)
    {
        $projectModel = new ProjectModel();

        $project = $projectModel->find($id);

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project not found.");
        }

        $projectModel->delete($id);

        return redirect()->to('/admin/projects')->with('success', 'Project deleted successfully.');
    }
}
