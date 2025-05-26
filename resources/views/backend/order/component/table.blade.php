<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Vận chuyển</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_code }}</td>
            <td>{{ $order->user->name }}</td>
            <td>{{ number_format($order->total_amount) }}đ</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <select class="form-control order-status" data-id="{{ $order->id }}">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control tracking-number" 
                       data-id="{{ $order->id }}" 
                       value="{{ $order->tracking_number }}"
                       placeholder="Nhập mã vận đơn">
            </td>
            <td>
                <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye"></i> Chi tiết
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Không có đơn hàng nào</td>
        </tr>
        @endforelse
    </tbody>
</table>
{{ $orders->links('pagination::bootstrap-4') }}