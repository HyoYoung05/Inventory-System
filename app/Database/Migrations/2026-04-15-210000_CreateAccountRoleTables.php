<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountRoleTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'account_type' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'staff'],
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id', false, true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('admin_staff_accounts', true);

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id', false, true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buyer_accounts', true);

        $this->db->query("
            INSERT INTO admin_staff_accounts (user_id, account_type, created_at, updated_at)
            SELECT users.id, users.role, users.created_at, users.updated_at
            FROM users
            LEFT JOIN admin_staff_accounts ON admin_staff_accounts.user_id = users.id
            WHERE users.role IN ('admin', 'staff')
              AND admin_staff_accounts.user_id IS NULL
        ");

        $this->db->query("
            INSERT INTO buyer_accounts (user_id, created_at, updated_at)
            SELECT users.id, users.created_at, users.updated_at
            FROM users
            LEFT JOIN buyer_accounts ON buyer_accounts.user_id = users.id
            WHERE users.role = 'user'
              AND buyer_accounts.user_id IS NULL
        ");
    }

    public function down()
    {
        $this->forge->dropTable('buyer_accounts', true);
        $this->forge->dropTable('admin_staff_accounts', true);
    }
}
