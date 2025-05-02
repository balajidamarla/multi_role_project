<?php

namespace App\Controllers;

use App\Models\SignModel;
use App\Models\ProjectModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class SignController extends Controller
{
    public function index()
    {
        $signModel = new SignModel();
        $data['signs'] = $signModel->findAll();
        return view('admin/signs', $data);
    }

    public function create()
    {
        $projectModel = new ProjectModel();
        $userModel = new UserModel();

        $data['projects'] = $projectModel->findAll();
        $data['teamMembers'] = $userModel
            ->whereIn('role', ['sales_surveyor', 'surveyor_lite'])
            ->findAll();

        return view('admin/create_sign', $data);
    }

    public function store()
    {
        $signModel = new SignModel();
        $signModel->save([
            'project_id' => $this->request->getPost('project_id'),
            'assigned_to' => $this->request->getPost('assigned_to'),
            'sign_description' => $this->request->getPost('sign_description'),
            'sign_type' => $this->request->getPost('sign_type'),
            'status' => 'pending',
            'start_date' => $this->request->getPost('start_date'),
            'completion_date' => $this->request->getPost('completion_date'),
            'created_by' => session()->get('user_id'),
        ]);

        return redirect()->to('admin/signs')->with('success', 'Sign assigned successfully.');
    }

    public function delete($id)
    {
        $signModel = new SignModel();
        $signModel->delete($id);
        return redirect()->to('admin/signs')->with('success', 'Sign deleted.');
    }
}
