<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\CheckoutRepositoryInterface;

class CheckoutRepository implements CheckoutRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function createOrder(array $data)
    {
        return $this->model->create($data);
    }

    public function getOrderById($id)
    {
        return $this->model->find($id);
    }

    public function updateOrder($id, array $data)
    {
        $order = $this->model->find($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null;
    }

    public function deleteOrder($id)
    {
        $order = $this->model->find($id);
        if ($order) {
            return $order->delete();
        }
        return false;
    }

    public function getOrdersByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }
}