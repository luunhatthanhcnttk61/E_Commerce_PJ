<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
     protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate($filter = [])
    {
        $query = $this->model;

        if (!empty($filter['keyword'])) {
            $query = $query->where(function($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter['keyword'] . '%')
                  ->orWhere('email', 'like', '%' . $filter['keyword'] . '%')
                  ->orWhere('phone', 'like', '%' . $filter['keyword'] . '%');
            });
        }

        if (isset($filter['status'])) {
            $query = $query->where('status', $filter['status']);
        }

        return $query->paginate(10);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $customer = $this->findById($id);
        if ($customer) {
            return $customer->update($data);
        }
        return false;
    }

    public function delete($id)
    {
        $customer = $this->findById($id);
        if ($customer) {
            return $customer->delete();
        }
        return false;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
}