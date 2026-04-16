<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Books', 'description' => 'Books and publications'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden supplies'],
            ['name' => 'Sports', 'description' => 'Sports equipment and apparel'],
        ];

        $builder = $this->db->table('categories');

        foreach ($data as $row) {
            $exists = $builder->where('name', $row['name'])->countAllResults();
            if ($exists > 0) {
                continue;
            }

            $builder->insert($row);
        }
    }
}
