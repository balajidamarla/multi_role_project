<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\SignModel;


class SurveyorController extends BaseController
{
    public function dashboard()
    {
        return view('salessurveyor/dashboard');
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
}
