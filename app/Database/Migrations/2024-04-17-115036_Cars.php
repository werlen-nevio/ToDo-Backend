<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cars extends Migration
{
    public function up()
    {
        $this->db->query('CREATE TABLE cars (
            id INT(11) NOT NULL AUTO_INCREMENT,
            car_brand VARCHAR(255),
            car_name VARCHAR(255),
            color_hex VARCHAR(6),
            comments TEXT,
            car_type_id INT(11),
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
