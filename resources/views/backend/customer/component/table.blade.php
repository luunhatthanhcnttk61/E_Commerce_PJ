<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Số đơn hàng</th>
            <th>Tổng chi tiêu</th>
            <th>Loại khách</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->orders_count }}</td>
            <td>{{ number_format($customer->total_spent) }}đ</td>
            <td>
                @if($customer->is_vip)
                    <span class="label label-primary">VIP</span>
                @elseif($customer->is_new)
                    <span class="label label-info">Mới</span>
                @else
                    <span class="label label-default">Thường</span>
                @endif
            </td>
            <td>
                <div class="switch">
                    <div class="onoffswitch">
                        <input type="checkbox" class="onoffswitch-checkbox js-switch" 
                               data-id="{{ $customer->id }}"
                               id="customer{{ $customer->id }}"
                               {{ $customer->status ? 'checked' : '' }}>
                        <label class="onoffswitch-label" for="customer{{ $customer->id }}"></label>
                    </div>
                </div>
            </td>
            <td>
                <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye"></i> Chi tiết
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->links('pagination::bootstrap-4') }}