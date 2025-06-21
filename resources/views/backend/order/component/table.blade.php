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
                @php
                    $statuses = [
                        'pending' => 'Chờ xử lý',
                        'processing' => 'Đang xử lý',
                        'shipped' => 'Đang giao',
                        'delivered' => 'Đã giao',
                        'cancelled' => 'Đã hủy'
                    ];
                @endphp
                <span class="badge 
                    {{ $order->order_status == 'pending' ? 'badge-warning' : '' }}
                    {{ $order->order_status == 'processing' ? 'badge-primary' : '' }}
                    {{ $order->order_status == 'shipped' ? 'badge-info' : '' }}
                    {{ $order->order_status == 'delivered' ? 'badge-success' : '' }}
                    {{ $order->order_status == 'cancelled' ? 'badge-danger' : '' }}"
                >
                    {{ $statuses[$order->order_status] ?? 'Không xác định' }}
                </span>
            </td>
            <td>
                <input type="text" class="form-control tracking-number" 
                       data-id="{{ $order->id }}" 
                       value="{{ $order->tracking_number }}"
                       placeholder="Nhập mã vận đơn">
            </td>
            <td>
                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary btn-sm">
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