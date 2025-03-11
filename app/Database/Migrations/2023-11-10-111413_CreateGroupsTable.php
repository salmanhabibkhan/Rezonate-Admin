<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'group_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'group_title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 40,
                    'default' => '',
                ],
                'avatar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 120,
                    'default' => 'upload/photos/d-group.jpg',
                ],
                'cover' => [
                    'type' => 'VARCHAR',
                    'constraint' => 120,
                    'default' => 'upload/photos/d-cover.jpg',
                ],
                'about' => [
                    'type' => 'VARCHAR',
                    'constraint' => 550,
                    'default' => '',
                ],
                'category' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 1,
                ],
                'sub_category' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => '',
                ],
                'privacy' => [
                    'type' => 'ENUM',
                    'constraint' => ['1', '2'],
                    'default' => '1',
                ],
                'join_privacy' => [
                    'type' => 'ENUM',
                    'constraint' => ['1', '2'],
                    'default' => '1',
                ],
                'active' => [
                    'type' => 'ENUM',
                    'constraint' => ['0', '1'],
                    'default' => '0',
                ],
                'registered' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '0/0000',
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
            $this->forge->createTable('groups');
        }
    }

    public function down()
    {
        //
    }
}
