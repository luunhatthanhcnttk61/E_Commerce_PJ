<div class="row mb-3">
    <div class="col-lg-12">
        <form action="{{ route('admin.review.index') }}" method="GET">
            <div class="row">
                <!-- Tìm kiếm theo từ khóa -->
                <div class="col-md-3 mb-3">
                    <input type="text" name="keyword" 
                           class="form-control" 
                           placeholder="Tìm kiếm..." 
                           value="{{ request()->keyword }}">
                </div>
                
                <!-- Lọc theo trạng thái -->
                <div class="col-md-3 mb-3">
                    <select name="status" class="form-control">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>
                            Chờ duyệt
                        </option>
                        <option value="approved" {{ request()->status == 'approved' ? 'selected' : '' }}>
                            Đã duyệt
                        </option>
                        <option value="rejected" {{ request()->status == 'rejected' ? 'selected' : '' }}>
                            Từ chối
                        </option>
                    </select>
                </div>
                
                <!-- Nút tìm kiếm -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>
</div>