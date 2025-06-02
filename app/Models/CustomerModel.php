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
        'state',
        'city',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = false; // set true if you want CI4 to handle timestamps automatically
    protected $returnType = 'array';

    /**
     * Get customers created by a specific admin
     *
     * @param int $adminId
     * @return array
     */
    public function getCustomersByAdmin(int $adminId): array
    {
        return $this->where('created_by', $adminId)
            ->orderBy('id', 'DESC')
            ->findAll();
    }
}
