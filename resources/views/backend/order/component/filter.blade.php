<div class="filter-wrapper">
    <form action="{{ route('admin.order.index') }}" method="GET">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <select name="status" class="form-control">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
            <div class="search">
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                       placeholder="Tìm theo mã đơn hoặc tên khách hàng" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>