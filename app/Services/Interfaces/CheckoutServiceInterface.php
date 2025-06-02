<?php

namespace App\Services\Interfaces;

interface CheckoutServiceInterface
{
    public function getCart();
    public function getTotal();
    public function createOrder(array $data);
    public function getOrder($orderId);
    public function getPaymentUrl($order, $paymentMethod);
    public function handlePaymentCallback(array $data);
}