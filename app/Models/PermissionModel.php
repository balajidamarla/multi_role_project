<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'label', 'created_by'];
    protected $returnType = 'array';

    public function getPermissionsByAdmin(int $adminId, int $limit = 5)
    {
        return $this->where('created_by', $adminId)
            ->orderBy('id', 'DESC')
            ->paginate($limit);
    }

    public function getPager()
    {
        return $this->pager;
    }
}
