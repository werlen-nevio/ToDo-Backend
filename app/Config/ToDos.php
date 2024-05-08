<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ToDos extends BaseConfig
{
    public $todo_types = [
        1 => 'Coupe',
        2 => 'Cabriolet',
        3 => 'Limousine',
        4 => 'Sportwagen',
        5 => 'Kompaktwagen',
        6 => 'SUV',
    ];

    public $show_todo_type = true;
}
