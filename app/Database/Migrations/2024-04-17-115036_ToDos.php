<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ToDos extends Migration
{
    public function up()
    {

		$this->db->query('CREATE TABLE todos (
        todo_id INT(11) NOT NULL AUTO_INCREMENT,
		todo_name VARCHAR(255),
		todo_description TEXT,
		todo_date DATETIME,
		todo_status VARCHAR(255),
		todo_category VARCHAR(255),
		category_id INT(11) NOT NULL AUTO_INCREMENT,
		category_name VARCHAR(255),		
		date DATETIME,
		action VARCHAR(255),
		table VARCHAR(255),
		data_json_old VARCHAR(255),
		data_json_new VARCHAR(255),
    }
	)');
    }

    public function down()
    {
        //
    }
}
