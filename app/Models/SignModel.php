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
        // Build the query to fetch the sign data with the customer, project, and user details
        $builder = $this->db->table('signs');
        $builder->select('signs.*, customers.company_name AS customer_name, projects.name AS project_name, users.first_name, users.last_name, users.role');
        $builder->join('customers', 'signs.customer_id = customers.id', 'left'); // Join customers using customer_id
        $builder->join('projects', 'signs.project_id = projects.id', 'left'); // Join projects to get the project name
        $builder->join('users', 'signs.assigned_to = users.id', 'left'); // Join users to get the assigned person's name and role
        $builder->where('signs.project_id', $projectId); // Filter by the project_id

        // Execute the query and return the result as an array
        return $builder->get()->getResultArray();
    }
}
