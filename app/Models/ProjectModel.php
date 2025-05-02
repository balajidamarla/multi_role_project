<?php
namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'customer_id', 'name', 'description', 'status', 'created_by', 'assigned_to'
    ];
    protected $useTimestamps = true;
}
