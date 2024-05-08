<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ToDos extends Migration
{
    public function up()
    {
        $this->db->query('CREATE TABLE todos (
            id INT(11) NOT NULL AUTO_INCREMENT,
            todo_brand VARCHAR(255),
            todo_name VARCHAR(255),
            color_hex VARCHAR(6),
            comments TEXT,
            todo_type_id INT(11),
            created_at DATETIME,
            updated_at DATETIME,
            deleted_at DATETIME,
            PRIMARY KEY (id)
        )');
    }

    public function down()
    {
        //
    }
}
