<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\ProjectModel;
use App\Models\SignModel;
use App\Models\UserModel;

class CustomerController extends BaseController
{
    // Display all customers
    public function index()
    {
        $session = session();
        $user_role = $session->get('role');

        $customerModel = new CustomerModel();
        $customers = $customerModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/customers/index', [
            'customers' => $customers,
            'user_role' => $user_role
        ]);
    }

    public function show($id)
    {
        $session = session();
        $user_role = $session->get('role');

        $customerModel = new CustomerModel();
        $projectModel = new ProjectModel();
        $signModel = new SignModel();

        // Fetch the customer by ID
        $customer = $customerModel->find($id);

        // If customer is not found, show 404 error
        if (!$customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Customer not found.");
        }

        // Get related project IDs
        $projects = $projectModel->where('customer_id', $id)->findAll();
        $projectIds = array_column($projects, 'id');

        // Count signs/tasks
        $signCount = 0;
        if (!empty($projectIds)) {
            $signCount = $signModel->whereIn('project_id', $projectIds)->countAllResults();
        }

        return view('admin/customers/show', [
            'customer' => $customer,
            'signCount' => $signCount,
            'user_role' => $user_role
        ]);
    }


    // Delete a customer (only for non-surveyors)
    public function delete($id)
    {
        $session = session();
        $user_role = $session->get('role');

        if ($user_role === 'salessurveyor') {
            return redirect()->back()->with('error', 'You are not authorized to delete customers.');
        }

        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $customerModel->delete($id);
        return redirect()->to(base_url('admin/customers'))->with('success', 'Customer deleted successfully.');
    }

    // Generate report (allowed for all roles)
    public function report($id)
    {
        $session = session();
        $user_role = $session->get('role');

        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        return view('admin/customers/report', [
            'customer' => $customer,
            'user_role' => $user_role
        ]);
    }
    public function create()
    {
        $session = session();
        $user_role = $session->get('role'); // Get the role from the session

        $customerModel = new CustomerModel();
        $userModel = new UserModel(); // Assuming you have a UserModel for fetching users

        $customers = $customerModel->findAll();
        $users = $userModel->findAll(); // Get all users for team assignment

        return view('projects/create', [
            'customers' => $customers,
            'users' => $users,
            'user_role' => $user_role // Pass the role to the view
        ]);
    }
}
