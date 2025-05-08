<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'company_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address1',
        'address2',
        'zipcode',
        'city_state',
        'created_by'
    ];

    protected $useTimestamps = false;
}
