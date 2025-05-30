<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate($filter = [])
    {
        $query = $this->model;

        if (!empty($filter['keyword'])) {
            $query = $query->where('name', 'like', '%' . $filter['keyword'] . '%');
        }

        if (isset($filter['status'])) {
            $query = $query->where('status', $filter['status']);
        }

        return $query->paginate(10);
    }

    public function getAll()
    {
        return $this->model->where('status', 'active')->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->findById($id);
        if ($category) {
            return $category->update($data);
        }
        return false;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        if ($category) {
            return $category->delete();
        }
        return false;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
}