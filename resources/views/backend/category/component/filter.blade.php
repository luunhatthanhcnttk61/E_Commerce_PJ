<div class="row mb-3">
    <div class="col-lg-12">
        <form action="{{ route('admin.category.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm..." value="{{ request()->keyword }}">
                </div>
                <div class="col-md-3 mb-3">
                    <select name="status" class="form-control">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('admin.category.create') }}" class="btn btn-success">Thêm mới</a>
                </div>
            </div>
        </form>
    </div>
</div>