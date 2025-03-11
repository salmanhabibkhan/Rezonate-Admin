<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagsTable extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                
            ],
            'description' => [
                'type' => 'TEXT',
                'null'=>true
            ],
        
            
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
          
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tags');
    
        
    }

    public function down()
    {
        //
    }
}
