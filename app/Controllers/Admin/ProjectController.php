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

        // Get the current logged-in user's ID and role
        $userId = session()->get('user_id');
        $data['user_id'] = $userId;

        $user = $userModel->find($userId);
        $data['role'] = $user['role'];

        // Get projects created by the current admin
        $data['projects'] = $projectModel->getProjectsByAdmin($userId);

        // Fetch all signs and group them by project_id
        $signs = $signModel->findAll();
        $signsByProject = [];

        foreach ($signs as $sign) {
            $projectId = $sign['project_id'];

            // Fetch assigned user's name based on 'assigned_to' field
            $assignedUser = $userModel->find($sign['assigned_to']);
            $assignedToName = $assignedUser ? $assignedUser['first_name'] . ' ' . $assignedUser['last_name'] : 'Unassigned';

            // Add assigned_to_name to each sign
            $sign['assigned_to_name'] = $assignedToName;

            if (!isset($signsByProject[$projectId])) {
                $signsByProject[$projectId] = [];
            }
            $signsByProject[$projectId][] = $sign;
        }

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
    // public function create()
    // {
    //     $projectModel = new ProjectModel();
    //     $userModel = new UserModel();

    //     $data['projects'] = $projectModel->projects(); // this fetches project + customer info
    //     $data['surveyors'] = $userModel
    //         ->whereIn('role', ['salessurveyor', 'Surveyor Lite'])
    //         ->findAll();

    //     return view('admin/signs/create', $data);
    // }

    // public function createProject()
    // {
    //     // Initialize models
    //     $customerModel = new \App\Models\CustomerModel();
    //     $userModel = new \App\Models\UserModel();

    //     // Fetch all customers
    //     $data['customers'] = $customerModel->findAll();

    //     // Only fetch users with relevant roles
    //     $data['users'] = $userModel
    //         ->whereNotIn('role', ['salessurveyor', 'Surveyor Lite'])
    //         ->findAll();

    //     // Get the user's role
    //     $data['role'] = session()->get('role');

    //     // Pass data to the view
    //     return view('admin/projects/creates', $data);
    // }

    public function create()
    {
        $customerModel = new CustomerModel();
        $userModel = new UserModel();

        $adminId = (int) session()->get('user_id'); // current logged-in admin ID

        // Only fetch customers created by this admin
        $customers = $customerModel->getCustomersByAdmin($adminId);
        $users = $userModel->findAll(); // You can optionally filter by role if needed

        return view('admin/projects/create', [
            'customers' => $customers,
            'users'     => $users
        ]);
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


    public function store()
    {
        $projectModel = new \App\Models\ProjectModel();

        $data = [
            'customer_id' => $this->request->getPost('customer_id'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
            'assigned_to' => $this->request->getPost('assigned_to'),
            'created_by'  => session()->get('user_id'), // or however you track logged user
        ];

        if ($projectModel->insert($data)) {
            return redirect()->to('/admin/projects')->with('success', 'Project created successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create project');
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

        // Get current admin ID
        $adminId = session()->get('user_id');

        // Get users with roles salessurveyor or surveyorlite created by this admin
        $users = $userModel->where('created_by', $adminId)
            ->whereIn('role', ['salessurveyor', 'surveyorlite'])
            ->findAll();

        // Include current admin in the list
        $currentAdmin = $userModel->find($adminId);
        if ($currentAdmin) {
            $users[] = $currentAdmin;
        }

        // Remove duplicates (if admin also created himself)
        $users = array_unique($users, SORT_REGULAR);

        // Fetch customer based on customer_id in project
        $customer = $customerModel->find($project['customer_id']);

        // Add full customer name to project array
        $project['customer_name'] = $customer['first_name'] . ' ' . $customer['last_name'];

        return view('admin/projects/edit', [
            'project' => $project,
            'users'   => $users
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
