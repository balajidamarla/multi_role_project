<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
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

    protected $useTimestamps = true;

    // Fetch detailed info for one project by ID
    public function getProjectById($id)
    {
        return $this->db->table('projects')
            ->select('
                projects.*, 
                customers.company_name,
                customers.first_name,
                customers.last_name,
                customers.address1,
                customers.address2,
                customers.state,
                customers.city,
                customers.zipcode,
                customers.email,
                customers.phone,
                customers.created_at AS customer_created_at
            ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->where('projects.id', $id)
            ->get()
            ->getFirstRow('array'); // Specify return type
    }

    // Fetch all projects with customer and assigned user data
    public function projects()
    {
        return $this->db->table('projects')
            ->select('
                projects.*, 
                CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,
                CONCAT(customers.address1, ", ", customers.address2, ", ", customers.state, ", ", customers.city) AS customer_address,
                customers.zipcode,
                customers.company_name,
                customers.phone AS contact_info,
                customers.created_at AS customer_created_at,
                users.first_name AS assigned_to_name
            ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->orderBy('projects.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
    public function getProjectsByAdmin($adminId)
    {
        return $this->db->table('projects')
            ->select('
                projects.*, 
                CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,
                CONCAT(customers.address1, ", ", customers.address2, ", ", customers.state, ", ", customers.city) AS customer_address,
                customers.zipcode,
                customers.company_name,
                customers.phone AS contact_info,
                customers.created_at AS customer_created_at,
                users.first_name AS assigned_to_name
            ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->where('projects.created_by', $adminId)
            ->orderBy('projects.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getAllProjects()
    {
        return $this->db->table('projects')
            ->select('
            projects.*, 
            CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,
            CONCAT(customers.address1, ", ", customers.address2, ", ", customers.state, ", ", customers.city) AS customer_address,
            customers.zipcode,
            customers.company_name,
            customers.phone AS contact_info,
            customers.created_at AS customer_created_at,
            users.first_name AS assigned_to_name
        ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->orderBy('projects.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getProjectsByAssignedUser($userId)
    {
        return $this->db->table('projects')
            ->select('
            projects.*, 
            CONCAT(customers.first_name, " ", customers.last_name) AS customer_name,
            CONCAT(customers.address1, ", ", customers.address2, ", ", customers.state, ", ", customers.city) AS customer_address,
            customers.zipcode,
            customers.company_name,
            customers.phone AS contact_info,
            customers.created_at AS customer_created_at,
            users.first_name AS assigned_to_name
        ')
            ->join('customers', 'customers.id = projects.customer_id')
            ->join('users', 'users.id = projects.assigned_to', 'left')
            ->where('projects.assigned_to', $userId)
            ->orderBy('projects.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }


    public function getCustomersByAdmin(int $adminId): array
    {
        return $this->where('created_by', $adminId)
            ->orderBy('company_name', 'ASC')
            ->findAll();
    }
}
