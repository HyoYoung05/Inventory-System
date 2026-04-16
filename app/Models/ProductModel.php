<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Set to true if you add a deleted_at column

    // Crucial for CRUD operations [cite: 23]
    // Only fields listed here can be inserted/updated via save(), insert(), or update()
    protected $allowedFields    = [
        'category_id', 
        'sku', 
        'name', 
        'description', 
        'price', 
        'stock_quantity',
        'image_path',
    ];

    // Dates for automated tracking 
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation Requirements [cite: 31, 147]
    protected $validationRules = [
        'id'             => 'permit_empty|is_natural_no_zero',
        'category_id'    => 'required|is_not_unique[categories.id]',
        'sku'            => 'required|min_length[3]|max_length[50]|regex_match[/^[A-Za-z0-9\\-\\s]+$/]|is_unique[products.sku,id,{id}]',
        'name'           => 'required|min_length[3]|max_length[150]',
        'price'          => 'required|decimal',
        'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'sku' => [
            'is_unique' => 'This SKU already exists in the inventory.',
            'regex_match' => 'SKU may only contain letters, numbers, spaces, and hyphens.',
        ],
    ];

    public function getNextSku(): string
    {
        $latestProduct = $this->select('id')
            ->orderBy('id', 'DESC')
            ->first();

        $nextNumber = ((int) ($latestProduct['id'] ?? 0)) + 1;

        return 'SKU-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Custom method to get products with their category names
     * Demonstrates proper relationships 
     */
    public function getProductsWithCategory(?string $search = null)
    {
        $builder = $this->select('products.*, categories.name as category_name')
                        ->join('categories', 'categories.id = products.category_id');

        if ($search !== null && $search !== '') {
            $builder->groupStart()
                    ->like('products.name', $search)
                    ->orLike('products.sku', $search)
                    ->groupEnd();
        }

        return $builder->orderBy('products.created_at', 'DESC')->findAll();
    }

    public function getProductsByIdsWithCategory(array $ids): array
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if (empty($ids)) {
            return [];
        }

        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->whereIn('products.id', $ids)
            ->findAll();
    }
}
