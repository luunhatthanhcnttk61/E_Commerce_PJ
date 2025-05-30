<?php

namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    public function paginate(){
        $user = $this->userRepository->getAllPaginate();
        return $user;
    }

    public function create($data)
    {
        return $this->userRepository->create($data);
    }
    public function update($id, $data)
    {
        return $this->userRepository->update($id, $data);
    }
    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }
    public function findById($id)
    {
        return $this->userRepository->findById($id);
    }

}
