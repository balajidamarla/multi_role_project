<?php

namespace App\Controllers;
use App\Models\CustomerModel;

class SurveyorController extends BaseController
{
    public function dashboard()
    {
        return view('salessurveyor/dashboard');
    }
    public function manageCustomers()
    {
        // Ensure only users with the 'sales_surveyor' role can access
        $session = session();
        $role = $session->get('user_role');

        if ($role !== 'sales_surveyor') {
            return redirect()->to('/')->with('error', 'Access denied.');
        }

        // Load model
        $customerModel = new CustomerModel();

        // Fetch customers (customize as needed)
        $data['customers'] = $customerModel->findAll();

        // Pass role to view for conditional UI rendering
        $data['user_role'] = $role;

        // Load the view
        return view('admin/customers/show', $data);
    }
}
