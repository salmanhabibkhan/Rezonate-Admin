<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMoviesTable extends Migration
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
                'movie_name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'default' => '',
                ],
                'genre' => [
                    'type' => 'ENUM("Action", "Adventure", "Comedy", "Drama", "Thriller", "Horror", "Science Fiction (Sci-Fi)", "Fantasy", "Mystery", "Romance", "Animation", "Family", "Superhero", "Documentary", "Biography")',
                    'default' => 'Action',
                ],
                'stars' => [
                    'type' => 'VARCHAR',
                    'constraint' => 300,
                    'default' => '',
                ],
                'producer' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'default' => '',
                ],
                'release_year' => [
                    'type' => 'YEAR',
                    'null' => true,
                ],
                'duration' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'cover_pic' => [
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'default' => '',
                    'null'=>true,
                ],
                'source' => [
                    'type' => 'VARCHAR',
                    'constraint' => 1000,
                    'default' => '',
                ],
                'video' => [
                    'type' => 'VARCHAR',
                    'constraint' => 3000,
                    'default' => '',
                ],
                'views' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
                'rating' => [
                    'type' => 'VARCHAR',
                    'constraint' => 11,
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
    
            $this->forge->addKey('id', true);
          
    
            $this->forge->createTable('movies');
    
    }

    public function down()
    {
        //
    }
}
