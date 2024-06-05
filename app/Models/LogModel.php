<?php
namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'Datum',
        'KeyID',
        'Aktion',
        'Tabelle',
        'DataJSON_Old',
        'DataJSON_New'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}
