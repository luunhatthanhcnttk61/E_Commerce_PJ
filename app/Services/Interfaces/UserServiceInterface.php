<?php

namespace App\Services\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface UserServiceInterface
{
    public function paginate();
    public function updateStatus($userId, $status);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function findById($id);

}
