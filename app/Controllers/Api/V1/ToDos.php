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
}
