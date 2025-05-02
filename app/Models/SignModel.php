<?php

namespace App\Models;

use CodeIgniter\Model;

class SignModel extends Model
{
    protected $table = 'signs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'project_id',
        'assigned_to',
        'sign_description',
        'sign_type',
        'status',
        'start_date',
        'completion_date',
        'created_by',
        'created_at'
    ];
}
