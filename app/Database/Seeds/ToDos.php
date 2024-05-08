<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ToDos extends Seeder
{
    public function run()
    {
        $exampleData = [
            [
                'todo_brand'     => 'Porsche',
                'todo_name'      => '911 GT3',
                'color_hex'     => '93065b',
                'comments'      => '',
                'todo_type_id'   => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'todo_brand'     => 'Audi',
                'todo_name'      => 'TT RS',
                'color_hex'     => 'FFFFFF',
                'comments'      => '',
                'todo_type_id'   => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'todo_brand'     => 'BMW',
                'todo_name'      => 'M3 Competition',
                'color_hex'     => 'FF0000',
                'comments'      => '',
                'todo_type_id'   => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];

        $ToDoModel = new \App\Models\ToDoModel();

        foreach ($exampleData as $entry_id => $data) {
            if ($ToDoModel->insert($data) === false) {
                echo "Errors on entry_id ${entry_id}:\n";
                print_r($ToDoModel->errors());
            }
        }
    }
}
