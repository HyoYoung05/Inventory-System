<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBuyerProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        $fields = [];

        if (! $this->db->fieldExists('first_name', 'users')) {
            $fields['first_name'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'id',
            ];
        }

        if (! $this->db->fieldExists('last_name', 'users')) {
            $fields['last_name'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'first_name',
            ];
        }

        if (! $this->db->fieldExists('email', 'users')) {
            $fields['email'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'last_name',
            ];
        }

        if (! $this->db->fieldExists('contact', 'users')) {
            $fields['contact'] = [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
                'after' => 'username',
            ];
        }

        if (! $this->db->fieldExists('date_of_birth', 'users')) {
            $fields['date_of_birth'] = [
                'type' => 'DATE',
                'null' => true,
                'after' => 'contact',
            ];
        }

        if (! $this->db->fieldExists('address', 'users')) {
            $fields['address'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'date_of_birth',
            ];
        }

        if (! $this->db->fieldExists('zip_code', 'users')) {
            $fields['zip_code'] = [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'address',
            ];
        }

        if (! $this->db->fieldExists('country', 'users')) {
            $fields['country'] = [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'zip_code',
            ];
        }

        if ($fields !== []) {
            $this->forge->addColumn('users', $fields);
        }

        if (! $this->db->fieldExists('email', 'users')) {
            return;
        }

        $indexes = $this->db->getIndexData('users');
        if (! array_key_exists('email', $indexes)) {
            $this->forge->addUniqueKey('email');
            $this->forge->processIndexes('users');
        }
    }

    public function down()
    {
        $columns = ['country', 'zip_code', 'address', 'date_of_birth', 'contact', 'email', 'last_name', 'first_name'];
        foreach ($columns as $column) {
            if ($this->db->fieldExists($column, 'users')) {
                $this->forge->dropColumn('users', $column);
            }
        }
    }
}
