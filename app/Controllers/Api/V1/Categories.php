<?php
namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;

class Categories extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    /**
     * Get all Categories
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $categories = $this->model->findAll();
        return $this->respond($categories);
    }

    /**
     * Get a single category by ID
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function show($id = null)
    {
        $category = $this->model->find($id);
        if ($category) {
            return $this->respond($category);
        }
        return $this->failNotFound('Category not found');
    }

    /**
     * Create a new category
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Update an existing category
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Delete a category
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id = null)
    {
        if ($this->model->find($id)) {
            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id, 'message' => 'Category deleted']);
        }
        return $this->failNotFound('Category not found');
    }
}
