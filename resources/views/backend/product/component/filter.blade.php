<div class="filter-wrapper">
    <form action="{{ route('admin.product.index') }}" method="GET">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-between">
                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                        @foreach([10, 20, 30, 40, 50] as $val)
                            <option value="{{ $val }}" {{ request()->input('perpage') == $val ? 'selected' : '' }}>
                                {{ $val }} bản ghi
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <div class="uk-search uk-flex uk-flex-middle mr10">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{ request()->keyword }}" 
                                   placeholder="Nhập từ khóa..." class="form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary mb0 btn-sm">Tìm kiếm</button>
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('admin.product.create') }}" class="btn btn-danger">
                        <i class="fa fa-plus mr5"></i>Thêm mới sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>