<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'label', 'created_by'];

    // In app/Models/RoleModel.php
    public function getRolesWithPermissions()
    {
        $builder = $this->db->table('roles r');
        $builder->select('r.id, r.name, GROUP_CONCAT(p.name SEPARATOR ", ") as permissions');
        $builder->join('role_permission rp', 'rp.role_id = r.id', 'left');
        $builder->join('permissions p', 'p.id = rp.permission_id', 'left');
        $builder->groupBy('r.id');

        return $builder->get()->getResultArray();
    }

    public function getRolesByAdmin(int $adminId): array
    {
        return $this->db->table('roles r')
            ->select('r.id, r.name, r.label, GROUP_CONCAT(p.name SEPARATOR ", ") as permissions')
            ->join('role_permission rp', 'rp.role_id = r.id', 'left')
            ->join('permissions p', 'p.id = rp.permission_id', 'left')
            ->where('r.created_by', $adminId)
            ->groupBy('r.id')
            ->orderBy('r.id', 'ASC')
            ->get()
            ->getResultArray();
    }
}
