<?php

namespace App\Repositories\Interfaces;

interface CheckoutRepositoryInterface
{
    public function createOrder(array $data);
    public function getOrderById($id);
    public function updateOrder($id, array $data);
    public function deleteOrder($id);
    public function getOrdersByUserId($userId);
}