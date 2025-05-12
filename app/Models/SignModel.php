<?php

namespace App\Models;

use CodeIgniter\Model;

class SignModel extends Model
{
    protected $table = 'signs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sign_name',
        'project_id',
        'customer_id',
        'assigned_to',
        'sign_description',
        'sign_type',
        'address',
        'due_date',
        'progress',
        'start_date',
        'completion_date',
        'created_by',
        'created_at',
    ];

    /**
     * Get signs with customer, project, and assigned user details
     *
     * @param int $projectId
     * @return array
     */
    public function getSignsWithDetails($projectId)
    {
        return $this->db->table('signs')
            ->select('
                signs.*, 
                customers.first_name AS customer_first_name, 
                customers.last_name AS customer_last_name,
                customers.company_name AS customer_company, 
                projects.name AS project_name, 
                users.first_name AS assigned_first_name, 
                users.last_name AS assigned_last_name, 
                users.role AS assigned_role
            ')
            ->join('customers', 'signs.customer_id = customers.id', 'left')
            ->join('projects', 'signs.project_id = projects.id', 'left')
            ->join('users', 'signs.assigned_to = users.id', 'left')
            ->where('signs.project_id', $projectId)
            ->orderBy('signs.due_date', 'ASC')
            ->get()
            ->getResultArray();
    }
}
