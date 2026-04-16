<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ScopeUsernameUniquenessByAccountType extends Migration
{
    public function up()
    {
        $indexes = $this->db->getIndexData('users');

        if (isset($indexes['username'])) {
            $this->db->query('ALTER TABLE users DROP INDEX username');
        }

        if (!isset($indexes['idx_users_username'])) {
            $this->db->query('ALTER TABLE users ADD INDEX idx_users_username (username)');
        }
    }

    public function down()
    {
        $indexes = $this->db->getIndexData('users');

        if (isset($indexes['idx_users_username'])) {
            $this->db->query('ALTER TABLE users DROP INDEX idx_users_username');
        }

        if (!isset($indexes['username'])) {
            $this->db->query('ALTER TABLE users ADD UNIQUE INDEX username (username)');
        }
    }
}
