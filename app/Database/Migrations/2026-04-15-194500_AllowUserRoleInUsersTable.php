<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AllowUserRoleInUsersTable extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','staff','user') NOT NULL DEFAULT 'user'");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','staff') NOT NULL DEFAULT 'staff'");
    }
}
