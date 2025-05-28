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
        'dynamic_sign_type',
        'address',
        'due_date',
        'progress',
        'start_date',
        'completion_date',
        'created_by',
        'created_at',

        // Newly added fields
        'replacement',
        'removal_scheduled',
        'todo',
        'summary',
        'permit_required',
        'todo_permit',
        'summary_permit',
        'existing_sign_audit',
        'permitting_assessment',
        'surveyor_kit',
        'sign_image',
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

    public function getSignWithDetails($id)
    {
        return $this->select('signs.*, projects.name AS project_name, customers.first_name AS first_name,customers.last_name AS last_name')
            ->join('projects', 'projects.id = signs.project_id', 'left')
            ->join('customers', 'customers.id = signs.customer_id', 'left')
            ->where('signs.id', $id)
            ->first();
    }

    // With paginate support for Admin
    public function getSignsByAdminPaginated(int $adminId, int $perPage = 5)
    {
        return $this->select('
            signs.*, 
            CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,
            customers.company_name AS company_name,
            projects.name AS project_name,
            assigned_user.first_name AS assigned_first_name,
            assigned_user.last_name AS assigned_last_name
        ')
            ->join('customers', 'customers.id = signs.customer_id', 'left')
            ->join('projects', 'projects.id = signs.project_id', 'left')
            ->join('users as assigned_user', 'assigned_user.id = signs.assigned_to', 'left')
            ->where('signs.created_by', $adminId)
            ->orderBy('signs.created_at', 'DESC')
            ->paginate($perPage);
    }

    // With paginate support for assigned user
    public function getSignsByAssignedUserPaginated($userId, int $perPage = 5)
    {
        return $this->select('
        signs.*,
        projects.name AS project_name,
        CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,
        CONCAT(customers.address1, ", ", customers.address2, ", ", customers.city_state) AS customer_address,
        customers.zipcode,
        customers.company_name,
        customers.phone AS contact_info,
        customers.created_at AS customer_created_at
    ')
            ->join('projects', 'projects.id = signs.project_id', 'left')
            ->join('customers', 'customers.id = projects.customer_id', 'left')
            ->where('signs.assigned_to', $userId)
            ->orderBy('signs.due_date', 'DESC')
            ->paginate($perPage);
    }
}
