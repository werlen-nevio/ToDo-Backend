<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;


class ToDos extends ResourceController
{

    protected $modelName = 'App\Models\ToDoModel';
    protected $format = 'json';

    protected $config = null;

    /**
     * Constructor
     */
    public function __construct() {

        // Load custom config: ToDos
        $this->config = config('ToDos');

    }

    /**
     * Get all todos
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index() {

        // Get filtered data
        $all_data = $this->model->findAll();
        
        // Check filtered data
        if (!empty($all_data)) {
            
            // Respond data
            return $this->respond($all_data);
        }

        // Show error
        return $this->failNotFound();

    }

    /**
     * Get single todo with specific ID
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function show($id = null) {

        if (!empty($id)) {

            $data = $this->model->find($id);

            if (!empty($data)) {

                if ($this->config->show_todo_types) {

                    if (!empty($data['todo_type_id'])
                         && 
                        isset($this->config->todo_types[$data['todo_type_id']])
                        ) {
                            
                        $data['todo_type'] = $this->config->todo_types[$data['todo_type_id']];

                    }

                }

                // Respond data
                return $this->respond($data);

            }


        }

        return $this->failNotFound();
    }

    /**
     * POST / Create new entry
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function create() {
        
        // Get & prepare data
        $data = $this->request->getJSON(true);

        if (!empty($data)) {

            // Add meta data
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            // Try to insert & check validation
            $new_id = $this->model->insert($data);

            if ($new_id === false) {
                return $this->failValidationErrors($this->model->errors());
            }
            else {
                return $this->respondCreated(['id' => $new_id] + $data);
            }
        }

        // Fail
        return $this->failServerError();

    }

    /**
     * PUT & PATCH / Update an entry
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null) {

        if (!empty($id)) {

            $data_exists = $this->model->find($id);

            if (!empty($data_exists)) {

                // Get & prepare data
                $data = $this->request->getJSON(true);

                if (!empty($data)) {

                    // Add meta data
                    $data['updated_at'] = date('Y-m-d H:i:s');
        
                    // Try to update & check validation
                    if ($this->model->update($id, $data) === false) {
                        return $this->failValidationErrors($this->model->errors());
                    }
                    else {
                        return $this->respondUpdated(['id' => $id] + $data);
                    }
                }
                
            }

        }

        return $this->failNotFound();

    }

    /**
     * Delete / Delete an entry
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id = null) {

        if (!empty($id)) {

            $data_exists = $this->model->find($id);

            if (!empty($data_exists)) {

                $delete_status = $this->model->delete($id);

                if ($delete_status === true) {
                    return $this->respondDeleted(['id' => $id]);
                }
            }
            else {
                return $this->failNotFound();
            }

        }
        
        return $this->failServerError();

    }
}