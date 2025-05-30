<div class="row mb-3">
    <div class="col-lg-12">
        <form action="{{ route('admin.contact.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="text" name="keyword" class="form-control" 
                           placeholder="Tìm kiếm..." value="{{ request()->keyword }}">
                </div>
                <div class="col-md-3 mb-3">
                    <select name="status" class="form-control">
                        <option value="">Tất cả trạng thái</option>
                        <option value="new" {{ request()->status == 'new' ? 'selected' : '' }}>Mới</option>
                        <option value="read" {{ request()->status == 'read' ? 'selected' : '' }}>Đã đọc</option>
                        <option value="replied" {{ request()->status == 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        </form>
    </div>
</div>