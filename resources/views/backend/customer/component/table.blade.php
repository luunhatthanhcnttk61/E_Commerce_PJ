<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Số đơn hàng</th>
            <th>Tổng chi tiêu</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>
                <input type="checkbox" value="{{ $customer->id }}" class="input-checkbox checkBoxItem">
            </td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->orders_count }}</td>
            <td>{{ number_format($customer->total_spent ?? 0) }}đ</td>
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
                <a href="{{ route('admin.customer.show', $customer->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $customers->links('pagination::bootstrap-4') }}