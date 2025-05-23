<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'status',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $returnType = 'array';

    public function getTeamMembersByAdmin(int $adminId): array
    {
        return $this->db->table('users')
            ->select('*')
            ->whereIn('role', ['salessurveyor', 'Surveyor Lite'])
            ->where('created_by', $adminId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
    
}
