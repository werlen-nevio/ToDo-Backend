<?php

namespace App\Models;

use CodeIgniter\Model;

class ToDoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'todos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['todo_brand', 'todo_name', 'color_hex', 'comments', 'todo_type_id'];

        // Dates
        protected $useTimestamps = true;
        protected $dateFormat    = 'datetime';
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';
    
        // Validation
        protected $validationRules = [
            'todo_brand'     => 'required|alpha_numeric_space|min_length[2]',
            'todo_name'      => 'required|alpha_numeric_space',
            'color_hex'     => 'permit_empty|exact_length[6]|hex',
            'comments'      => 'permit_empty|alpha_numeric_punct',
            'todo_type_id'   => 'required|is_natural_no_zero'
        ];
        
        protected $validationMessages   = [];
        protected $skipValidation       = false;
        protected $cleanValidationRules = true;
    
        // Callbacks
        protected $allowCallbacks = true;
        protected $beforeInsert   = [];
        protected $afterInsert    = [];
        protected $beforeUpdate   = [];
        protected $afterUpdate    = [];
        protected $beforeFind     = [];
        protected $afterFind      = [];
        protected $beforeDelete   = [];
        protected $afterDelete    = [];
    
    
        /**
         * Get filtered data
         *
         * @param array $filter
         * @return array
         */
        public function getFiltered($filter) {
    
            // Prepare return
            $return = array();
    
            // Set query with builder
            $builder = $this->db->table($this->table);
    
            // Set limit & offset
            if (!empty($filter['limit'])) {
    
                if (!empty($filter['offset'])) {
                    $builder->limit($filter['limit'], $filter['offset']);
                }
                else {
                    $builder->limit($filter['limit']);
                }
    
            }
    
            // Set order by
            if (!empty($filter['order'])) {
                $builder->orderBy($filter['order']);
            }
    
            // Check specific: todo_type_id
            if (!empty($filter['todo_type_id'])) {
                $builder->where('todo_type_id', $filter['todo_type_id']);
            }
    
            // Get data
            $query = $builder->get();
    
            // Get count all
           
            // Prepare data
            $return['total'] = $builder->countAll();
            $return['data'] = array();
            foreach ($query->getResultArray() as $row) {
                $return['data'][$row[$this->primaryKey]] = $row;
            }
            
            // Return data
            return $return;
    
        }
    
    }