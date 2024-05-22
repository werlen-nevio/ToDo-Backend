<?php
namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;

class ToDos extends ResourceController
{
    protected $modelName = 'App\Models\ToDoModel';
    protected $format    = 'json';

    /**
     * Get all todos
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $todos = $this->model->findAll();
        return $this->respond($todos);
    }

    /**
     * Get a single todo by ID
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function show($id = null)
    {
        $todo = $this->model->find($id);
        if ($todo) {
            return $this->respond($todo);
        }
        return $this->failNotFound('Todo not found');
    }
}
