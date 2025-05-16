<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table = 'role_permission';
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_id', 'permission_id'];

    /**
     * Get permissions assigned to a given role ID
     * Returns an array of permission records (at least with 'name')
     */
    public function getPermissionsByRoleId($roleId)
    {
        return $this->db->table('permissions p')
            ->select('p.*')
            ->join('role_permission rp', 'rp.permission_id = p.id')
            ->where('rp.role_id', $roleId)
            ->get()
            ->getResultArray();
    }
}
