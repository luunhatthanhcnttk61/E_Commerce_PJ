<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface as CategoryRepository;
use App\Services\Interfaces\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories($request)
    {
        $filter = [];
        if($request->keyword) {
            $filter['keyword'] = $request->keyword;
        }
        if($request->status) {
            $filter['status'] = $request->status;
        }
        return $this->categoryRepository->getAllPaginate($filter);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function create($data)
    {
        return $this->categoryRepository->create($data);
    }

    public function findById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function update($id, $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }

    public function findBySlug($slug)
    {
        return $this->categoryRepository->findBySlug($slug);
    }
}