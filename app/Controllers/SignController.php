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

        // Get signs
        if (in_array($role, ['salessurveyor', 'surveyorlite'])) {
            $signs = $this->signModel->getSignsByAssignedUser($userId);
        } else {
            $signs = $this->signModel->getSignsByAdmin($userId);
        }

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
            'progress'           => $this->request->getPost('progress'),
            'due_date'         => $this->request->getPost('due_date'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ];

        $signModel->update($id, $signData);

        session()->setFlashdata('success', 'Sign updated successfully.');
        return redirect()->to(base_url('admin/signs'));
    }


    public function view($id)
    {
        $signModel = new \App\Models\SignModel();

        $sign = $signModel->find($id);

        if (!$sign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Sign not found");
        }

        return view('admin/signs/view', ['sign' => $sign]);
    }
}
