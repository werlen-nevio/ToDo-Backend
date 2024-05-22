<?php

namespace App\Models;

use CodeIgniter\Model;

class ToDoModel extends Model
{
    protected $table = 'todo';
    protected $primaryKey = 'ToDoID';
    protected $allowedFields = [
        'bezeichnung',
        'beschreibung',
        'datum',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}