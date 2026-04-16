<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'description'];

    // Automated tracking for TA3 requirements [cite: 46]
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Basic validation for category creation [cite: 31]
    protected $validationRules = [
        'id'   => 'permit_empty|is_natural_no_zero',
        'name' => 'required|min_length[3]|max_length[100]|is_unique[categories.name,id,{id}]',
    ];
}
