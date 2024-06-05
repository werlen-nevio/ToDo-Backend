<?php
namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;

class ToDos extends ResourceController
{
    protected $modelName = 'App\Models\ToDoModel';
    protected $format    = 'json';

    /**
     * Get all todos with pagination and sorting
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $limit = $this->request->getGet('limit') ?? 10; // limit
        $page = $this->request->getGet('page') ?? 1; // page
        $orderBy = $this->request->getGet('order_by') ?? 'ToDoID'; // order by
        $orderDirection = $this->request->getGet('order_direction') ?? 'asc'; // order direction
        $categoryId = $this->request->getGet('category_id'); // category_id

        $offset = ($page - 1) * $limit;

        $query = $this->model
                      ->orderBy($orderBy, $orderDirection)
                      ->select('todo.*');

        // Apply category filter
        if ($categoryId) {
            $query->join('kategorieconn', 'todo.ToDoID = kategorieconn.ToDoID', 'left')
                  ->where('kategorieconn.KategorieID', $categoryId);
        }

        // Fetch todos with pagination and sorting
        $todos = $query->findAll($limit, $offset);

        // Get total number of todos
        $totalQuery = $this->model;
        if ($categoryId) {
            $totalQuery->join('kategorieconn', 'todo.ToDoID = kategorieconn.ToDoID', 'left')
                       ->where('kategorieconn.KategorieID', $categoryId);
        }
        $total = $totalQuery->countAllResults(false);

        // Get categories for todos
        $todoIds = array_column($todos, 'ToDoID');
        $categories = [];
        if (!empty($todoIds)) {
            $categoriesQuery = $this->model->db->table('kategorieconn')
                ->select('ToDoID, KategorieID')
                ->whereIn('ToDoID', $todoIds)
                ->get();

            foreach ($categoriesQuery->getResultArray() as $row) {
                $categories[$row['ToDoID']][] = $row['KategorieID'];
            }
        }

        // Add categories to todos
        foreach ($todos as &$todo) {
            $todo['categories'] = $categories[$todo['ToDoID']] ?? [];
        }

        $response = [
            'data' => $todos,
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
     * Get a single todo by ID
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function show($id = null)
    {
        $todo = $this->model->find($id);
        if ($todo) {
            // Get categories of the todo
            $categoriesQuery = $this->model->db->table('kategorieconn')
                ->select('KategorieID')
                ->where('ToDoID', $id)
                ->get();

            $categories = [];
            foreach ($categoriesQuery->getResultArray() as $row) {
                $categories[] = $row['KategorieID'];
            }

            $todo['categories'] = $categories;

            return $this->respond($todo);
        }
        return $this->failNotFound('Todo not found');
    }

    /**
     * Create a new todo
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON(true);

        // Manually check if 'categories' is an array if provided
        if (isset($data['categories']) && !is_array($data['categories'])) {
            return $this->failValidationError('Categories must be an array');
        }

        // Validate other data
        if (!$this->validate([
            'Bezeichnung' => 'required|max_length[255]',
            'Beschreibung' => 'max_length[255]',
            'Datum' => 'required|valid_date[Y-m-d H:i:s]',
            'Status' => 'required|in_list[0,1]'
        ])) {
            return $this->fail($this->validator->getErrors());
        }

        // Extract categories if present
        $categories = isset($data['categories']) ? $data['categories'] : [];
        unset($data['categories']);

        // Add new todo
        $todoId = $this->model->insert($data);
        if ($todoId === false) {
            return $this->failServerError('Failed to create todo');
        }

        // Insert categories into kategorieconn if provided
        if (!empty($categories)) {
            $kategorieconnTable = $this->model->db->table('kategorieconn');
            foreach ($categories as $categoryId) {
                $kategorieconnTable->insert([
                    'ToDoID' => $todoId,
                    'KategorieID' => $categoryId
                ]);
            }
        }

        $todo = $this->model->find($todoId);
        // Add the categories to the response
        $todo['categories'] = $categories;

        return $this->respondCreated($todo);
    }

    /**
     * Delete a todo by ID
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id = null)
    {
        // Check if the todo exists
        $todo = $this->model->find($id);
        if ($todo) {
            // Delete related conns from kategorieconn
            $this->model->db->table('kategorieconn')->where('ToDoID', $id)->delete();
            // Delete the todo
            $this->model->delete($id);
            return $this->respondDeleted(['message' => 'Todo deleted successfully']);
        }
        return $this->failNotFound('Todo not found');
    }

    /**
     * Update a todo by ID (partial update)
     *
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Todo not found');
        }

        $data = $this->request->getJSON(true);

        // Manually check if 'categories' is an array if provided
        if (isset($data['categories']) && !is_array($data['categories'])) {
            return $this->failValidationError('Categories must be an array');
        }

        // Extract categories if present
        $categories = isset($data['categories']) ? $data['categories'] : null;
        unset($data['categories']);

        // Prepare validation rules, only add rules for fields that are present in the request
        $validationRules = [];
        if (isset($data['Bezeichnung'])) {
            $validationRules['Bezeichnung'] = 'max_length[255]';
        }
        if (isset($data['Beschreibung'])) {
            $validationRules['Beschreibung'] = 'max_length[255]';
        }
        if (isset($data['Datum'])) {
            $validationRules['Datum'] = 'valid_date[Y-m-d H:i:s]';
        }
        if (isset($data['Status'])) {
            $validationRules['Status'] = 'in_list[0,1]';
        }

        // Validate the provided data
        if (!empty($validationRules) && !$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors());
        }

        // Update todo, only with provided data
        if (!empty($data) && !$this->model->update($id, $data)) {
            return $this->failServerError('Failed to update todo');
        }

        // Update categories in kategorieconn if provided
        if ($categories !== null) {
            $kategorieconnTable = $this->model->db->table('kategorieconn');
            $kategorieconnTable->where('ToDoID', $id)->delete();
            if (!empty($categories)) {
                foreach ($categories as $categoryId) {
                    $kategorieconnTable->insert([
                        'ToDoID' => $id,
                        'KategorieID' => $categoryId
                    ]);
                }
            }
        }

        $todo = $this->model->find($id);
        // Add the categories to the response
        if ($categories !== null) {
            $todo['categories'] = $categories;
        } else {
            // Fetch current categories if not provided in the request
            $categoriesQuery = $this->model->db->table('kategorieconn')
                ->select('KategorieID')
                ->where('ToDoID', $id)
                ->get();

            $currentCategories = [];
            foreach ($categoriesQuery->getResultArray() as $row) {
                $currentCategories[] = $row['KategorieID'];
            }
            $todo['categories'] = $currentCategories;
        }

        return $this->respond($todo);
    }

}