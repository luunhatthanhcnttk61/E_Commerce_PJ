<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function getAllPaginate($request);
    public function findById($id);
    public function updateStatus($id, $status);
    public function updateTracking($id, $trackingNumber);
    public function createOrder($data);
    public function updateOrder($id, array $data);
    public function deleteOrder($id);
}