<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $db;

    protected $table = 'projects';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'customer_id',
        'name',
        'description',
        'status',
        'assigned_to',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // Enable timestamps (for created_at and updated_at)
    protected $useTimestamps = true;  // Automatically handles `created_at` and `updated_at`

    // Optional: If you don't want to use automatic timestamps, make sure you manage them manually
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function projects()
    {
        return $this->db->table('projects')
            ->select('
            projects.*, 
            CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,  
            CONCAT(customers.address1, " ", customers.address2, " ", customers.city_state) AS customer_address,  
            customers.zipcode,
            customers.phone AS contact_info,
            customers.created_at AS customer_created_at,
            users.first_name AS assigned_to_name  
        ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->orderBy('projects.created_at', 'DESC')
            ->get()->getResultArray();
    }
}
