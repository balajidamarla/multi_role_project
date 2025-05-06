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
        'created_at'
    ];
}
