<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;
use App\Services\Interfaces\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface 
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function paginate()
    {
        return $this->customerRepository->getAllPaginate();
    }

    public function getCustomers($request)
    {
        $filter = [];
        if($request->keyword) {
            $filter['keyword'] = $request->keyword;
        }
        if($request->status) {
            $filter['status'] = $request->status;
        }
        return $this->customerRepository->getAllPaginate($filter);
    }

    public function createCustomer($data)
    {
        return $this->customerRepository->createCustomer($data);
    }

    public function findById($id) 
    {
        return $this->customerRepository->findById($id);
    }

    public function updateCustomer($id, $data)
    {
        return $this->customerRepository->updateCustomer($id, $data);
    }

    public function updateStatus($id, $status)
    {
        return $this->customerRepository->updateCustomer($id, ['status' => $status]);
    }

    public function deleteCustomer($id)
    {
        return $this->customerRepository->deleteCustomer($id);
    }
}