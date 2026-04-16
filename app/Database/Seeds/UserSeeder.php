<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'admin',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'          => 'admin',
            ],
            [
                'username'      => 'staff',
                'password_hash' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'          => 'staff',
            ],
        ];

        $builder = $this->db->table('users');

        foreach ($data as $row) {
            $exists = $builder->where('username', $row['username'])->countAllResults();
            if ($exists > 0) {
                continue;
            }

            $builder->insert($row);
        }
    }
}
