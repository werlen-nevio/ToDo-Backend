<?php

namespace App\Models;

use CodeIgniter\Model;

class ToDoModel extends Model
{
    protected $table = 'todo';
    protected $primaryKey = 'ToDoID';
    protected $allowedFields = [
        'Bezeichnung',
        'Beschreibung',
        'Datum',
        'Status'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}