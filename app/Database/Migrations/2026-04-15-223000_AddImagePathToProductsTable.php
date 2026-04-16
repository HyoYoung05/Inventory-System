<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImagePathToProductsTable extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('image_path', 'products')) {
            $this->forge->addColumn('products', [
                'image_path' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'stock_quantity',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('image_path', 'products')) {
            $this->forge->dropColumn('products', 'image_path');
        }
    }
}
