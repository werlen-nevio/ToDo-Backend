<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class API extends BaseConfig
{

    public $check_api_key = TRUE;

    public $allowed_api_keys = [
        'km9uyxeq8pEGPcixfa3teyDHcPoabM' => 'Tobias',
        'P7Cy7yGwLo8RPFDzce4wuYqCGwWYmE' => 'Nevio'
    ];
}