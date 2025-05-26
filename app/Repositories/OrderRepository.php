<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate($request)
    {
        $query = $this->model->with(['user']);
        
        if(!empty($request->status)) {
            $query->where('status', $request->status);
        }

        if(!empty($request->keyword)) {
            $query->where('order_code', 'like', '%' . trim($request->keyword) . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . trim($request->keyword) . '%');
                  });
        }

        return $query->latest()->paginate($request->perpage ?? 10);
    }

    public function findById($id)
    {
        return $this->model->with(['user', 'orderDetails.product'])->find($id);
    }

    public function updateStatus($id, $status)
    {
        $order = $this->findById($id);
        if($order) {
            return $order->update(['status' => $status]);
        }
        return false;
    }

    public function updateTracking($id, $trackingNumber)
    {
        $order = $this->findById($id);
        if($order) {
            return $order->update(['tracking_number' => $trackingNumber]);
        }
        return false;
    }

    public function createOrder($data)
    {
        return $this->model->create($data);
    }

    public function updateOrder($id, array $data)
    {
        $order = $this->findById($id);
        if($order) {
            return $order->update($data);
        }
        return false;
    }

    public function deleteOrder($id)
    {
        $order = $this->findById($id);
        if($order) {
            return $order->delete();
        }
        return false;
    }
}