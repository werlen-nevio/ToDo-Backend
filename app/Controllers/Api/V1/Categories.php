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
        $limit = $this->request->getGet('limit') ?? 10; // limit
        $page = $this->request->getGet('page') ?? 1; // page
        $orderBy = $this->request->getGet('order_by') ?? 'KategorieID'; // order by
        $orderDirection = $this->request->getGet('order_direction') ?? 'asc'; // order direction

        $offset = ($page - 1) * $limit;

        $query = $this->model
                      ->orderBy($orderBy, $orderDirection);

        // Fetch categories with pagination and sorting
        $categories = $query->findAll($limit, $offset);

        // Get total number of categories
        $total = $this->model->countAllResults(false);

        $response = [
            'data' => $categories,
            'pagination' => [
                'total' => $total,
                'limit' => (int) $limit,
                'page' => (int) $page,
                'total_pages' => ceil($total / $limit),
            ]
        ];

        return $this->respond($response);
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
        $data = $this->request->getJSON(true);

        // Validate data
        if (!$this->validate([
            'Bezeichnung' => 'required|max_length[255]',
        ])) {
            return $this->fail($this->validator->getErrors());
        }

        // Add new category
        $categoryId = $this->model->insert($data);
        if ($categoryId === false) {
            return $this->failServerError('Failed to create category');
        }

        $category = $this->model->find($categoryId);

        return $this->respondCreated($category);
    }
}
