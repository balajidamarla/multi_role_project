<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class TeamController extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = (int) $session->get('user_id');
        $role = $session->get('role');

        $userModel = new \App\Models\UserModel();

        if (in_array($role, ['salessurveyor', 'surveyor lite'])) {
            // Only show the logged-in user
            $teams = [$userModel->find($userId)];
        } else {
            // Admin or other roles can see all team members they created
            $teams = $userModel->getTeamMembersByAdmin($userId);
        }

        return view('admin/teams', ['teams' => $teams]);
    }


    public function create()
    {
        return view('admin/create_team');
    }

    public function store()
    {
        // Validate inputs
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'password'   => 'required|min_length[6]',
            'role'       => 'required|in_list[salessurveyor,Surveyor Lite]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Log the data being passed to the controller
        log_message('debug', 'First Name: ' . $this->request->getPost('first_name'));
        log_message('debug', 'Last Name: ' . $this->request->getPost('last_name'));
        log_message('debug', 'Email: ' . $this->request->getPost('email'));
        log_message('debug', 'Role: ' . $this->request->getPost('role'));

        $adminId = session()->get('user_id'); // get logged-in admin ID

        // Save data to the database
        $userModel = new UserModel();
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'       => $this->request->getPost('role'),
            'created_by' => $adminId,  // Add this line
        ];

        if ($userModel->save($data)) {
            return redirect()->to('admin/teams')->with('success', 'Team member added successfully.');
        } else {
            // Log errors if the save operation fails
            log_message('error', 'Error saving user: ' . json_encode($userModel->errors()));
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }



    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('admin/teams')->with('success', 'Team member deleted.');
    }


    public function showCreateForm()
    {
        // Check permission
        if (!user_has_permission('create_team')) {
            return redirect()->to('/no-access');
        }

        // If allowed, show create team form or logic
        return view('team/create');
    }
}
