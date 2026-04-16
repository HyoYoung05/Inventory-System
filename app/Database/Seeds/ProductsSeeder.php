<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['sku' => 'SKU-001', 'name' => 'Laptop', 'description' => 'High-performance laptop', 'price' => 999.99, 'stock_quantity' => 50, 'category_id' => 1],
            ['sku' => 'SKU-002', 'name' => 'T-Shirt', 'description' => 'Cotton t-shirt', 'price' => 19.99, 'stock_quantity' => 100, 'category_id' => 2],
            ['sku' => 'SKU-003', 'name' => 'Novel', 'description' => 'Bestselling novel', 'price' => 14.99, 'stock_quantity' => 200, 'category_id' => 3],
            ['sku' => 'SKU-004', 'name' => 'Hammer', 'description' => 'Heavy duty hammer', 'price' => 24.99, 'stock_quantity' => 75, 'category_id' => 4],
            ['sku' => 'SKU-005', 'name' => 'Basketball', 'description' => 'Official size basketball', 'price' => 29.99, 'stock_quantity' => 30, 'category_id' => 5],
        ];

        $builder = $this->db->table('products');

        foreach ($data as $row) {
            $exists = $builder->where('sku', $row['sku'])->countAllResults();
            if ($exists > 0) {
                continue;
            }

            $builder->insert($row);
        }
    }
}
