<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyerAccountModel extends Model
{
    protected $table            = 'buyer_accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id' => 'permit_empty|is_natural_no_zero',
        'user_id' => 'required|is_natural_no_zero|is_unique[buyer_accounts.user_id,id,{id}]',
    ];
}
