<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserRepository implements UserRepositoryInterface
// {
//     public function getAllPaginate(){
//         return $user = User::paginate(3);
//     }
//     public function createUser($data)
//     {
//         return User::create($data);
//     }

//     public function updateUser($id, $data)
//     {
//          unset($data['_token']);
//         unset($data['_method']);
        
//         return User::where('id', $id)->update($data);
//     }
//     public function deleteUser($id)
//     {
//         return User::where('id', $id)->delete();
//     }
//     public function findById($id)
//     {
//         return User::find($id);
//     }

// }

{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate()
    {
        return $this->model->paginate(3);
    }

    public function createUser($data)
    {
        return $this->model->create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->findById($id);
        if($user) {
            return $user->update($data);
        }
        return false;
    }

    public function deleteUser($id)
    {
        $user = $this->findById($id);
        if($user) {
            return $user->delete();
        }
        return false;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
}