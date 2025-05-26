<?php

namespace App\Services;

use App\Services\Interfaces\OrderServiceInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;

class OrderService implements OrderServiceInterface
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrders($request)
    {
        return $this->orderRepository->getAllPaginate($request);
    }

    public function findById($id)
    {
        return $this->orderRepository->findById($id);
    }

    public function updateStatus($id, $status)
    {
        return $this->orderRepository->updateStatus($id, $status);
    }

    public function updateTracking($id, $trackingNumber)
    {
        return $this->orderRepository->updateTracking($id, $trackingNumber);
    }

    public function createOrder($data)
    {
        return $this->orderRepository->createOrder($data);
    }

    public function updateOrder($id, array $data)
    {
        return $this->orderRepository->updateOrder($id, $data);
    }

    public function deleteOrder($id)
    {
        return $this->orderRepository->deleteOrder($id);
    }
}