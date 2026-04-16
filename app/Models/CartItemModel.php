<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'product_id', 'quantity'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'user_id'    => 'required|integer|is_not_unique[users.id]',
        'product_id' => 'required|integer|is_not_unique[products.id]',
        'quantity'   => 'required|integer|greater_than[0]',
    ];
}
