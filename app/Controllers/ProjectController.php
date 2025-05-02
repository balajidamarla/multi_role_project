<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;
use App\Models\CustomerModel;

class ProjectController extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        $projects = $projectModel->findAll();  // Fetch all projects

        $customerModel = new CustomerModel();
        $customers = $customerModel->findAll();  // Fetch all customers to show in the "Add Project" form

        return view('admin/index', [
            'projects' => $projects,
            'customers' => $customers
        ]);
    }

    public function create()
    {
        $customerModel = new CustomerModel();
        $data['customers'] = $customerModel->findAll();
        return view('admin/projects/create', $data);
    }

    public function store()
    {
        $model = new ProjectModel();
        $model->save([
            'customer_id' => $this->request->getPost('customer_id'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
            'created_by'  => session()->get('user_id'),
            'assigned_to' => $this->request->getPost('assigned_to'),
        ]);
        return redirect()->to('admin/projects')->with('success', 'Project created successfully.');
    }

    public function delete($id)
    {
        $model = new ProjectModel();
        $model->delete($id);
        return redirect()->to('admin/projects')->with('success', 'Project deleted successfully.');
    }
}
