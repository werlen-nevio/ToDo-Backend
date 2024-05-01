<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Cars extends Seeder
{
    public function run()
    {
        $exampleData = [
            [
                'car_brand'     => 'Porsche',
                'car_name'      => '911 GT3',
                'color_hex'     => '93065b',
                'comments'      => '',
                'car_type_id'   => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'car_brand'     => 'Audi',
                'car_name'      => 'TT RS',
                'color_hex'     => 'FFFFFF',
                'comments'      => '',
                'car_type_id'   => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ],
            [
                'car_brand'     => 'BMW',
                'car_name'      => 'M3 Competition',
                'color_hex'     => 'FF0000',
                'comments'      => '',
                'car_type_id'   => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];

        $CarModel = new \App\Models\CarModel();

        foreach ($exampleData as $entry_id => $data) {
            if ($CarModel->insert($data) === false) {
                echo "Errors on entry_id ${entry_id}:\n";
                print_r($CarModel->errors());
            }
        }
    }
}
