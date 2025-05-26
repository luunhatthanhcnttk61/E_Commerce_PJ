<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Chi tiết đơn hàng #{{ $order->order_code }}</h5>
                <div class="ibox-tools">
                    <a href="{{ route('order.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Thông tin khách hàng</h4>
                        <p><strong>Tên:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Thông tin đơn hàng</h4>
                        <p><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                        <p><strong>Trạng thái:</strong> 
                            <select class="form-control order-status" data-id="{{ $order->id }}">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </p>
                    </div>
                </div>

                <h4>Chi tiết sản phẩm</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ number_format($detail->price) }}đ</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price * $detail->quantity) }}đ</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                            <td><strong>{{ number_format($order->total_amount) }}đ</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>