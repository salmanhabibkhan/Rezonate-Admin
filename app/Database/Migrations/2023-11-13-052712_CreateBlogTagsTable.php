<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogTagsTable extends Migration
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
            'tag_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'blog_id' => [
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
        $this->forge->createTable('blog_tags');
    
        
    }


    public function down()
    {
        //
    }
}
