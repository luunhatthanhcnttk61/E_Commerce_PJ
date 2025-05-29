<?php
@extends('frontend.layouts.master')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h1 class="my-4">Giỏ hàng của bạn</h1>

    @if(count($cart) > 0)
        <div class="table-responsive">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                                    <div class="product-info">
                                        <h4>{{ $item->product->name }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($item->price) }}đ</td>
                            <td>
                                <input type="number" 
                                       class="form-control quantity-input" 
                                       value="{{ $item->quantity }}"
                                       data-id="{{ $item->id }}"
                                       min="1">
                            </td>
                            <td>{{ number_format($item->total) }}đ</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-item"
                                        data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Tổng cộng:</td>
                        <td>{{ number_format($total) }}đ</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="cart-actions text-end mt-4">
            <a href="{{ route('client.home') }}" class="btn btn-outline-primary">
                Tiếp tục mua hàng
            </a>
            <a href="{{ route('client.checkout.index') }}" class="btn btn-primary">
                Thanh toán
            </a>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <h3>Giỏ hàng trống</h3>
            <a href="{{ route('client.home') }}" class="btn btn-primary mt-3">
                Tiếp tục mua hàng
            </a>
        </div>
    @endif
</div>
@endsection