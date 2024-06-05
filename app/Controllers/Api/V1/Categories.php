<?php
namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Models\LogModel;

class Categories extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogModel();
    }

    /**
     * Get all Categories with pagination and sorting
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
                      ->orderBy($orderBy, $orderDirection)
                      ->select('kategorie.*');

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
        $KategorieID = $this->model->insert($data);
        if ($KategorieID === false) {
            return $this->failServerError('Failed to create category');
        }

        $category = $this->model->find($KategorieID);

        // Log the creation
        $this->logAction(2, $KategorieID, null, $category);

        return $this->respondCreated($category);
    }

    /**
     * Delete a category by ID
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id = null)
    {
        // Check if the category exists
        $category = $this->model->find($id);
        if ($category) {
            // Delete related conns from kategorieconn
            $this->model->db->table('kategorieconn')->where('KategorieID', $id)->delete();
            // Delete the category
            $this->model->delete($id);

            // Log the deletion
            $this->logAction(1, $id, $category);

            return $this->respondDeleted(['message' => 'Category deleted successfully']);
        }
        return $this->failNotFound('Category not found');
    }

    /**
     * Update a category by ID
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null)
    {
        $oldCategory = $this->model->find($id);
        if (!$oldCategory) {
            return $this->failNotFound('Category not found');
        }

        $data = $this->request->getJSON(true);

        // Manually check if 'Bezeichnung' is provided
        if (!isset($data['Bezeichnung'])) {
            return $this->failValidationError('Bezeichnung must be provided');
        }

        // Prepare validation rules
        $validationRules = [
            'Bezeichnung' => 'max_length[255]'
        ];

        // Validate the provided data
        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors());
        }

        // Update category
        if (!$this->model->update($id, $data)) {
            return $this->failServerError('Failed to update category');
        }

        $newCategory = $this->model->find($id);

        // Log the update
        $this->logAction(3, $id, $oldCategory, $newCategory);

        return $this->respond($newCategory);
    }

    private function logAction($action, $categoryId, $oldData = null, $newData = null)
    {
        $data = [
            'Datum' => date('Y-m-d H:i:s'),
            'KeyID' => $categoryId,
            'Aktion' => $action,
            'Tabelle' => 2,
            'DataJSON_Old' => $oldData ? json_encode($oldData) : null,
            'DataJSON_New' => $newData ? json_encode($newData) : null
        ];

        $this->logModel->insert($data);
    }
}
