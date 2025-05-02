<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard');
    }
    public function manageCustomers()
    {
        $model = new CustomerModel();
        $data['customers'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('admin/manage_customers', $data);
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
            'city_state'   => $this->request->getPost('city'),
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
