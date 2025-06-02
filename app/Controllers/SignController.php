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
    protected $projectModel;

    public function __construct()
    {
        $this->signModel = new SignModel();
        $this->UserModel = new UserModel();
        // Load the database
        $this->db = \Config\Database::connect();
        $this->projectModel = new ProjectModel();
    }

    public function index()
    {
        $session = session();
        $userId = (int) $session->get('user_id');
        $role = $session->get('role');
        $perPage = 5;
        // Get signs
        if (in_array($role, ['salessurveyor', 'surveyorlite'])) {
            $signs = $this->signModel->getSignsByAssignedUserPaginated($userId,  $perPage);
        } else {
            $signs = $this->signModel->getSignsByAdminPaginated($userId,  $perPage);
        }
        $pager = $this->signModel->pager;

        $userBuilder = $this->UserModel->select('id, first_name, last_name, role');

        if ($role === 'admin') {
            // Admin sees all users they created + themselves
            $userBuilder->groupStart()
                ->where('created_by', $userId)
                ->whereIn('role', ['salessurveyor', 'surveyorlite'])
                ->groupEnd()
                ->orWhere('id', $userId);
        } elseif ($role === 'salessurveyor') {
            // Get admin who created this salessurveyor
            $creator = $this->UserModel->select('created_by')->where('id', $userId)->first();
            $adminId = $creator['created_by'] ?? null;

            $userBuilder->groupStart();

            if ($adminId) {
                // Include "surveyor lite" created by admin
                $userBuilder->orGroupStart()
                    ->where('created_by', $adminId)
                    ->where('role', 'surveyorlite')
                    ->groupEnd();

                // Include the admin (creator)
                $userBuilder->orWhere('id', $adminId);
            }

            // Include the salessurveyor (self)
            $userBuilder->orWhere('id', $userId);

            $userBuilder->groupEnd();
        } else {
            // Surveyor Lite only sees themselves
            $userBuilder->where('id', $userId);
        }

        $users = $userBuilder->findAll();

        return view('admin/signs/index', [
            'signs' => $signs,
            'users' => $users,
            'pager' => $pager,
        ]);
    }

    // public function create()
    // {
    //     $projectModel = new \App\Models\ProjectModel();
    //     $customerModel = new \App\Models\CustomerModel();
    //     $userModel = new \App\Models\UserModel();

    //     // Get all projects with customer names (if needed, use your `projects()` method)
    //     $data['projects'] = $projectModel->projects();

    //     // Get all customers
    //     $data['customers'] = $customerModel->findAll();

    //     // Get users with specific roles
    //     $data['users'] = $userModel
    //         ->select('id, first_name, last_name, role')
    //         ->whereIn('role', ['Admin', 'salessurveyor', 'Surveyor Lite'])
    //         ->findAll();

    //     // You can also pass the current user's role if needed in the view
    //     $data['role'] = session()->get('role');

    //     return view('admin/signs/create', $data);
    // }

    public function create($projectId)
    {
        $projectModel = new \App\Models\ProjectModel();
        $userModel = new \App\Models\UserModel();

        $project = $projectModel->getProjectById($projectId);
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Project not found.");
        }

        $adminId = (int) session()->get('user_id');

        // Fetch only surveyors created by this admin
        $surveyors = $userModel->getTeamMembersByAdmin($adminId);

        // Also include current admin if not already in the list
        $currentUser = $userModel->find($adminId);
        if ($currentUser) {
            $exists = array_filter($surveyors, fn($u) => $u['id'] == $adminId);
            if (empty($exists)) {
                $surveyors[] = $currentUser;
            }
        }

        return view('admin/signs/create', [
            'project'   => $project,
            'surveyors' => $surveyors
        ]);
    }





    public function store()
    {
        $project_id = $this->request->getPost('project_id');

        if (!$project_id) {
            return redirect()->back()->withInput()->with('error', 'Missing project ID.');
        }
        // var_dump($this->request->getPost('customer_id')); die;

        $this->signModel->save([
            'sign_name'        => $this->request->getPost('sign_name'),
            'project_id'       => $project_id,
            'customer_id'      => $this->request->getPost('customer_id'),
            'assigned_to'      => $this->request->getPost('assigned_to'),
            'sign_description' => $this->request->getPost('sign_description'),
            'sign_type'        => $this->request->getPost('sign_type'),
            'dynamic_sign_type' => $this->request->getPost('dynamic_sign_type'),
            'address'          => $this->request->getPost('address'),
            'due_date'         => $this->request->getPost('due_date'),
            'progress'         => $this->request->getPost('progress'),
            'created_by'       => session()->get('user_id'),
            'created_at'       => date('Y-m-d H:i:s'),

            // Newly added fields
            'replacement'           => $this->request->getPost('replacement'),
            'removal_scheduled'     => $this->request->getPost('removal_scheduled'),
            'todo'                  => $this->request->getPost('todo'),
            'summary'               => $this->request->getPost('summary'),
            'permit_required'       => $this->request->getPost('permit_required'),
            'todo_permit'           => $this->request->getPost('todo_permit'),
            'summary_permit'        => $this->request->getPost('summary_permit'),
            'existing_sign_audit'   => $this->request->getPost('existing_sign_audit'),
            'permitting_assessment' => $this->request->getPost('permitting_assessment'),
            'surveyor_kit'          => $this->request->getPost('surveyor_kit'),
            'sign_image'          => $this->request->getPost('sign_image'),

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

        $sign = $signModel->find($id);

        if (!$sign) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sign not found');
        }

        $currentAdminId = (int) session()->get('user_id');

        // Get only team members with specific roles created by this admin, including self
        $users = $userModel->where('created_by', $currentAdminId)
            ->whereIn('role', ['salessurveyor', 'surveyorlite'])
            ->orWhere('id', $currentAdminId) // include self
            ->findAll();

        return view('admin/signs/edit', [
            'sign' => $sign,
            'users' => $users,
            'currentUserId' => $currentAdminId,
        ]);
    }



    public function update($id)
    {
        $signModel = new \App\Models\SignModel();
        $sign = $signModel->find($id);

        if (!$sign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Sign not found.");
        }

        // Handle image upload
        $image = $this->request->getFile('sign_image');
        $sign_image = $sign['sign_image']; // default to existing image

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/assets/', $newName);
            $sign_image = $newName;

            // Optionally delete old image
            if (!empty($sign['sign_image']) && file_exists(ROOTPATH . 'public/assets/' . $sign['sign_image'])) {
                unlink(ROOTPATH . 'public/assets/' . $sign['sign_image']);
            }
        }

        // Handle missing assigned_to in POST (fallback to existing)
        $assignedTo = $this->request->getPost('assigned_to');
        if (empty($assignedTo)) {
            $assignedTo = $sign['assigned_to'];
        }

        // Prepare data to update
        $signData = [
            'sign_name'             => $this->request->getPost('sign_name') ?? $sign['sign_name'],
            'sign_type'             => $this->request->getPost('sign_type') ?? $sign['sign_type'],
            'dynamic_sign_type'     => $this->request->getPost('dynamic_sign_type') ?? $sign['dynamic_sign_type'],
            'replacement'           => $this->request->getPost('replacement') ?? $sign['replacement'],
            'removal_scheduled'     => $this->request->getPost('removal_scheduled') ?? $sign['removal_scheduled'],
            'todo'                  => $this->request->getPost('todo') ?? $sign['todo'],
            'summary'               => $this->request->getPost('summary') ?? $sign['summary'],
            'permit_required'       => $this->request->getPost('permit_required') ?? $sign['permit_required'],
            'todo_permit'           => $this->request->getPost('todo_permit') ?? $sign['todo_permit'],
            'summary_permit'        => $this->request->getPost('summary_permit') ?? $sign['summary_permit'],
            'existing_sign_audit'   => $this->request->getPost('existing_sign_audit') ?? $sign['existing_sign_audit'],
            'permitting_assessment' => $this->request->getPost('permitting_assessment') ?? $sign['permitting_assessment'],
            'surveyor_kit'          => $this->request->getPost('surveyor_kit') ?? $sign['surveyor_kit'],
            'assigned_to'           => $assignedTo,
            'progress'              => $this->request->getPost('progress') ?? $sign['progress'],
            'due_date'              => $this->request->getPost('due_date') ?? $sign['due_date'],
            'sign_description'      => $this->request->getPost('sign_description') ?? $sign['sign_description'],
            'sign_image'            => $sign_image,
        ];

        $signModel->update($id, $signData);

        session()->setFlashdata('success', 'Sign updated successfully.');
        return redirect()->to(base_url('admin/signs'));
    }




    public function view($id)
    {
        $signModel = new \App\Models\SignModel();

        $sign = $signModel->getSignWithDetails($id);

        if (!$sign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Sign not found");
        }

        return view('admin/signs/view', ['sign' => $sign]);
    }


    public function setDueDate()
    {
        $signId = $this->request->getPost('sign_id');
        $dueDate = $this->request->getPost('due_date');

        if ($signId && $dueDate) {
            $signModel = new \App\Models\SignModel();
            $signModel->update($signId, ['due_date' => $dueDate]);

            return redirect()->back()->with('success', 'Due date updated successfully!');
        }

        return redirect()->back()->with('error', 'Missing sign or date.');
    }

    public function search_signs()
    {
        $query = $this->request->getGet('query');
        $signModel = new \App\Models\SignModel();

        $signs = $signModel->like('sign_name', $query)
            ->select('signs.*, customers.company_name AS customer_name, projects.project_name, users.first_name, users.last_name, users.role')
            ->join('customers', 'customers.id = signs.customer_id')
            ->join('projects', 'projects.id = signs.project_id')
            ->join('users', 'users.id = signs.assigned_to', 'left')
            ->findAll();

        $result = [];

        foreach ($signs as $sign) {
            $assignedName = $sign['first_name'] ?? '';
            $assignedLast = $sign['last_name'] ?? '';
            $assignedRole = $sign['role'] ?? '';
            $sign['assigned_to_name'] = $assignedName ? "$assignedName $assignedLast ($assignedRole)" : 'Unassigned';
            $result[] = $sign;
        }

        return $this->response->setJSON($result);
    }
}
