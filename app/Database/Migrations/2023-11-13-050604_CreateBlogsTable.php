<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogsTable extends Migration
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
                'default' => 0,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'default' => '',
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'category' => [
                'type' => 'INT',
                'constraint' => 255,
                'default' => 0,
            ],
            'thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'upload/photos/d-blog.jpg',
            ],
            'view' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'shared' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'active' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1'],
                'default' => '1',
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
        $this->forge->createTable('blogs');
    
        
    }

    public function down()
    {
        //
    }
}
