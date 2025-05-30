<div class="filter-wrapper">
    <form action="{{ route('admin.customer.index') }}" method="GET">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <select name="customer_type" class="form-control">
                    <option value="">Tất cả khách hàng</option>
                    <option value="vip" {{ request('customer_type') == 'vip' ? 'selected' : '' }}>Khách VIP</option>
                    <option value="new" {{ request('customer_type') == 'new' ? 'selected' : '' }}>Khách mới</option>
                </select>
            </div>
            <div class="search">
                <input type="text" name="keyword" value="{{ request('keyword') }}" 
                       placeholder="Tìm theo tên hoặc email" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>
</div>