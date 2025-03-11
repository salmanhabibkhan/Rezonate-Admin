<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupAdminsTable extends Migration
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
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                
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
        $this->forge->createTable('group_admins');
    }

    public function down()
    {
        //
    }
}
