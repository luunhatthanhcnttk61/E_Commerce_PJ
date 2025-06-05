<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserRepositoryInterface
{
    public function getAllPaginate();
    public function updateStatus($userId, $status);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findById($id);
}
