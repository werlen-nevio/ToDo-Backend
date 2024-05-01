<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cars extends BaseConfig
{
    public $car_types = [
        1 => 'Coupe',
        2 => 'Cabriolet',
        3 => 'Limousine',
        4 => 'Sportwagen',
        5 => 'Kompaktwagen',
        6 => 'SUV',
    ];

    public $show_car_type = true;
}
