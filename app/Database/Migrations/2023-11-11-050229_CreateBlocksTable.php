<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlocksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'blocker' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'blocked' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
           
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('blocks');
    }

    public function down()
    {
        //
    }
}
