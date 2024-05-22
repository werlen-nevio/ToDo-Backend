<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'kategorie';
    protected $primaryKey = 'KategorieID';
    protected $allowedFields = [
        'bezeichnung'
    ];
    protected $returnType = 'array';
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}