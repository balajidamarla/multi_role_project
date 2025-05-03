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

    // Enable timestamps (for created_at and updated_at)
    protected $useTimestamps = true;  // Automatically handles `created_at` and `updated_at`

    // Optional: If you don't want to use automatic timestamps, make sure you manage them manually
}
