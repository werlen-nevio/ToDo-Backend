<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Todos extends Seeder
{
    public function run()
    {
        $exampleData = [
            [
                // Todo
                'todo_id'           => 1,
                'todo_name'         => 'Hausaufgaben machen',
                'todo_description'  => 'md. 395 Datenbank erstellen',
                'todo_date'         => '02.05.2024',
                'todo_status'       => 'offen',
                // Category Connection
                'todo_category'     => 'Schule',
                // Category
                'category_id'       => '1',
                'category_name'     => 'Schule',
                // Key
                'key_id'            => '1',
                'person'            => 'Max Mustermann',
                'key_name'          => 'schule_01',
                'created_at'        => date('Y-m-d H:i:s'),
                'valid_until'       => date('Y-m-d H:i:s'),
                // Log
                'date'              => '01.05.2024',
                //'key_id'            => '', foreign key from key
                'action'            => '',
                'table'             => '',
                'data_json_old'     => '',
                'data_json_new'     => '',

                //'updated_at'    => date('Y-m-d H:i:s')
            ],

            [
                // Todo
                'todo_id'           => 2,
                'todo_name'         => 'Hausaufgaben machen',
                'todo_description'  => 'md. 322 Persona erstellen',
                'todo_date'         => '03.05.2024',
                'todo_status'       => 'erldedigt',
                // Category Connection
                'todo_category'     => 'Schule',
                // Category
                'category_id'       => '2',
                'category_name'     => 'Schule',
                // Key
                'key_id'            => '2',
                'person'            => 'Max Mustermann',
                'key_name'          => 'schule_02',
                'created_at'        => date('Y-m-d H:i:s'),
                'valid_until'       => date('Y-m-d H:i:s'),
                // Log
                'date'              => '02.05.2024',
                //'key_id'            => '', foreign key from key
                'action'            => '',
                'table'             => '',
                'data_json_old'     => '',
                'data_json_new'     => '',

                //'updated_at'    => date('Y-m-d H:i:s')
            ]
            
        ];

        $TodoModel = new \App\Models\TodoModel();

        foreach ($exampleData as $entry_id => $data) {
            if ($TodoModel->insert($data) === false) {
                echo "Errors on entry_id ${entry_id}:\n";
                print_r($TodoModel->errors());
            }
        }
    }
}
