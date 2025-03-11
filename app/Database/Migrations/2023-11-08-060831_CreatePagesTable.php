<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagesTable extends Migration
{
    public function up()
    {
        {
            $this->forge->addField([
                'page_id' => [
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
                'page_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'page_title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'page_description' => [
                    'type' => 'VARCHAR',
                    'constraint' => 1000,
                    'default' => '',
                ],
                'avatar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'default' => 'upload/photos/d-page.jpg',
                ],
                'cover' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'default' => 'upload/photos/d-cover.jpg',
                ],
                'users_post' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'page_category' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 1,
                ],
                'sub_category' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => '',
                ],
                'website' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'default' => '',
                ],
                'facebook' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'google' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'vk' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'twitter' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'linkedin' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'company' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'phone' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'address' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'default' => '',
                ],
                'call_action_type' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'call_action_type_url' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'default' => '',
                ],
                'background_image' => [
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'default' => '',
                ],
                'background_image_status' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'instgram' => [
                    'type' => 'VARCHAR',
                    'constraint' => 32,
                    'default' => '',
                ],
                'youtube' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'default' => '',
                ],
                'verified' => [
                    'type' => 'ENUM',
                    'constraint' => ['0', '1'],
                    'default' => '0',
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
                'boosted' => [
                    'type' => 'ENUM',
                    'constraint' => ['0', '1'],
                    'default' => '0',
                ],
                'time' => [
                    'type' => 'INT',
                    'constraint' => 20,
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
    
            $this->forge->addKey('page_id', true);
            $this->forge->createTable('pages');
        }
    }

    public function down()
    {
        //
    }
}
