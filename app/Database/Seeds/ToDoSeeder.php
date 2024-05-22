<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ToDoSeeder extends Seeder
{
    public function run()
    {
        // Seed data for ToDo table
        $data = [
            [
                'Bezeichnung' => 'Task 1',
                'Beschreibung' => 'Description for task 1',
                'Datum' => '2024-05-22 10:00:00',
                'Status' => 1
            ],
            [
                'Bezeichnung' => 'Task 2',
                'Beschreibung' => 'Description for task 2',
                'Datum' => '2024-05-23 10:00:00',
                'Status' => 0
            ]
        ];
        $this->db->table('ToDo')->insertBatch($data);

        // Seed data for Kategorie table
        $data = [
            [
                'Bezeichnung' => 'Work'
            ],
            [
                'Bezeichnung' => 'Personal'
            ]
        ];
        $this->db->table('Kategorie')->insertBatch($data);

        // Seed data for KategorieConn table
        $data = [
            [
                'ToDoID' => 1,
                'KategorieID' => 1
            ],
            [
                'ToDoID' => 2,
                'KategorieID' => 2
            ]
        ];
        $this->db->table('KategorieConn')->insertBatch($data);
    }
}
