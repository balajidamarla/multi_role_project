<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard');
    }


    // public function manageCustomers()
    // {
    //     $role = session()->get('role');
    //     $userId = session()->get('user_id');

    //     if (!has_permission('view_customer')) {
    //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    //     }

    //     // Cast user ID to int
    //     $adminId = (int) $userId;

    //     $model = new \App\Models\CustomerModel();

    //     // Get customers created by this admin
    //     $customers = $model->getCustomersByAdmin($adminId);

    //     // Pass to view
    //     return view('admin/manage_customers', ['customers' => $customers]);
    // }

    public function manageCustomers()
    {
        $role = strtolower(session()->get('role'));
        $userId = session()->get('user_id');

        if (!has_permission('view_customer')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $model = new \App\Models\CustomerModel();

        if ($role === 'admin') {
            // Admin sees ONLY customers they created
            $customers = $model->where('created_by', $userId)->findAll();
        } elseif (in_array($role, ['salessurveyor', 'surveyorlite'])) {
            // These roles see only customers assigned to them
            $customers = $model->where('assigned_to', $userId)->findAll();
        } else {
            // Fallback: show only customers they created
            $customers = $model->where('created_by', $userId)->findAll();
        }

        return view('admin/manage_customers', ['customers' => $customers]);
    }








    public function addCustomerForm()
    {
        return view('admin/add_customer');
    }

    public function storeCustomer()
    {
        $model = new CustomerModel();

        $model->save([
            'company_name' => $this->request->getPost('company_name'),
            'first_name'   => $this->request->getPost('first_name'),
            'last_name'    => $this->request->getPost('last_name'),
            'email'        => $this->request->getPost('email'),
            'phone'        => $this->request->getPost('phone'),
            'address1'     => $this->request->getPost('address1'),
            'address2'     => $this->request->getPost('address2'),
            'zipcode'      => $this->request->getPost('zipcode'),
            'state'   => $this->request->getPost('state'),
            'city'   => $this->request->getPost('city'),
            'created_by'   => session()->get('user_id'), // assuming admin ID is stored in session
        ]);

        return redirect()->to('admin/manage_customers')->with('success', 'Customer added successfully.');
    }


    public function deleteCustomer($id)
    {
        $model = new CustomerModel();
        $model->delete($id);
        return redirect()->to('admin/manage_customers')->with('success', 'Customer deleted successfully.');
    }
}
