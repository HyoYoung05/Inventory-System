<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOrderStatuses extends Migration
{
    public function up()
    {
        $this->db->query("UPDATE orders SET status = 'to_be_packed' WHERE status = 'pending'");
        $this->db->query("ALTER TABLE orders MODIFY status ENUM('to_be_packed','to_be_shipped','to_be_delivered','completed','cancelled') NOT NULL DEFAULT 'to_be_packed'");
    }

    public function down()
    {
        $this->db->query("UPDATE orders SET status = 'pending' WHERE status = 'to_be_packed'");
        $this->db->query("UPDATE orders SET status = 'completed' WHERE status IN ('to_be_shipped','to_be_delivered')");
        $this->db->query("ALTER TABLE orders MODIFY status ENUM('pending','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }
}
