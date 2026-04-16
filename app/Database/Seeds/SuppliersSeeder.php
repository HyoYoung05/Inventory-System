<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuppliersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'TechCorp', 'contact' => 'John Doe', 'email' => 'john@techcorp.com', 'address' => '123 Tech St'],
            ['name' => 'FashionHub', 'contact' => 'Jane Smith', 'email' => 'jane@fashionhub.com', 'address' => '456 Fashion Ave'],
            ['name' => 'BookWorld', 'contact' => 'Bob Johnson', 'email' => 'bob@bookworld.com', 'address' => '789 Book Ln'],
            ['name' => 'HomeDepot', 'contact' => 'Alice Brown', 'email' => 'alice@homedepot.com', 'address' => '101 Home Rd'],
            ['name' => 'SportMax', 'contact' => 'Charlie Wilson', 'email' => 'charlie@sportmax.com', 'address' => '202 Sport Blvd'],
        ];

        $builder = $this->db->table('suppliers');

        foreach ($data as $row) {
            $exists = $builder->where('name', $row['name'])->countAllResults();
            if ($exists > 0) {
                continue;
            }

            $builder->insert($row);
        }
    }
}
