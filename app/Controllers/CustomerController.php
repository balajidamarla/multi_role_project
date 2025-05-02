<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\SignModel;

class CustomerController extends BaseController
{
    // Display all customers
    public function index()
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/customers/index', ['customers' => $customers]);
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

        return view('admin/customers/show', [
            'customer' => $customer,
            'signCount' => $signCount
        ]);
    }

    // Delete a customer
    public function delete($id)
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $customerModel->delete($id);
        return redirect()->to(base_url('admin/customers'))->with('success', 'Customer deleted successfully.');
    }

    // (Optional) Generate report for a customer
    public function report($id)
    {
        // Placeholder for generating report logic
        return "Report feature coming soon for customer ID: " . $id;
    }
}
