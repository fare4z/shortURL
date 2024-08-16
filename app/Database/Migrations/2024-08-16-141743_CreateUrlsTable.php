<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUrlsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'full_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 1000,
                'null'       => true,
            ],
            'qr' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'last_visit_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => 'current_timestamp()',
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => 'current_timestamp()',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('urls');
    }

    public function down()
    {
        $this->forge->dropTable('urls');
    }
}
