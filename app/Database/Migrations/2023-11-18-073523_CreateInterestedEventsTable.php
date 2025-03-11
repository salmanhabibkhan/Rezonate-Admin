<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInterestedEventsTable extends Migration
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
            'event_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'user_id' => [
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
          
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('interested_events');
    
        
   
    }

    public function down()
    {
        //
    }
}
